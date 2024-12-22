<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeTransactionResource\Pages;
use App\Models\SubscribeTransaction;
use App\Models\SubscribePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;


class SubscribeTransactionResource extends Resource
{
    protected static ?string $model = SubscribeTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Produk')
                    ->schema([

                        Forms\Components\Select::make('subscribe_package_id')

                            //memanggil paket subscribe & nama dari database
                            ->relationship('subscribePackage', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()

                            //After state updated : kalau value diatas kosong, ketika statenya berubah, langsung di update, mirip state management react

                            ->afterStateUpdated(function ($state, callable $set) {

                                $subscribePackage = SubscribePackage::find($state);
                                $price = $subscribePackage  ? $subscribePackage->price : 0;
                                $duration = $subscribePackage  ? $subscribePackage->duration : 0;

                                $set('price', $price);
                                $set('duration', $duration);

                                $tax = 0.11;
                                $totalTaxAmount = $tax * $price;

                                $totalAmount = $price + $totalTaxAmount;
                                $set('total_ammount', number_format($totalAmount, 0, '', ''));
                                $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                            })

                            //Ketika state sudah berubah, dari value 0 ke value berisi

                            ->afterStateHydrated(function (callable $get, callable $set, $state) {
                                $subscribePackageId = $state;
                                if ($subscribePackageId) {
                                    $subscribePackage = SubscribePackage::find($subscribePackageId);
                                    $price = $subscribePackage ?  $subscribePackage->price : 0;
                                    $set('price', $price);


                                    $tax = 0.11;
                                    $totalTaxAmount = $tax * $price;
                                    $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                                }
                            }),

                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                        Forms\Components\TextInput::make('total_ammount')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                        Forms\Components\TextInput::make('total_tax_amount')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                        Forms\Components\DatePicker::make('started_at')
                            ->required(),

                        Forms\Components\DatePicker::make('ended_at')
                            ->required(),

                        Forms\Components\TextInput::make('duration')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('Days'),
                    ]),

                Fieldset::make('Informasi kustomer')
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->maxLength(255),
                    ]),

                Fieldset::make('Informasi pembayaran')
                    ->schema([

                        Forms\Components\TextInput::make('booking_trx_id')
                            ->required()
                            ->maxLength(255),

                        ToggleButtons::make('is_paid')
                            ->label('Apakah sudah membayar ? ')
                            ->boolean()
                            ->grouped()
                            // ->icons([
                            //     true => 'heroicon-o-pencil',
                            //     false => 'heroicon-o-clock',
                            // ])
                            ->required(),

                        Forms\Components\FileUpload::make('proof')
                            ->image()
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('subscribePackage.icon'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi'),

            ])
            ->filters([
                //
                SelectFilter::make('subscribe_package_id')
                    ->label('Subscribe Package')
                    ->relationship('subscribePackage', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (SubscribeTransaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        Notification::make()
                            ->title('Transaction approved!')
                            ->success()
                            ->body('Transaksi sudah di approve')
                            ->send();
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(SubscribeTransaction $record) => !$record->is_paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribeTransactions::route('/'),
            'create' => Pages\CreateSubscribeTransaction::route('/create'),
            'edit' => Pages\EditSubscribeTransaction::route('/{record}/edit'),
        ];
    }
}
