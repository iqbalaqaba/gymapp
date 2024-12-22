<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GymResource\Pages;
use App\Filament\Resources\GymResource\RelationManagers;
use App\Models\Facilities;
use App\Models\Gym;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GymResource extends Resource
{
    protected static ?string $model = Gym::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                Fieldset::make('Products and price')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->rows(3)
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->required(),

                        //Komponen ini digunakan jika ada foto lebih dari 1
                        Forms\Components\Repeater::make('gymPhotos')
                            ->relationship('gymPhotos')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->required(),
                            ]),
                    ]),

                Fieldset::make('Additional')
                    ->schema([

                        Forms\Components\TextArea::make('about')
                            ->required(),

                        //Komponen ini digunakan untuk input fasilitas gym lebih dari 1
                        Forms\Components\Repeater::make('gymFacilities')
                            ->relationship('gymFacilities')
                            ->schema([
                                Forms\Components\Select::make('facility_id')
                                    ->label('Gym Facility')
                                    ->options(Facilities::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                            ]),

                        Forms\Components\Select::make('is_popular')
                            ->options([
                                true => 'Popular',
                                false => 'Not popular',
                            ])
                            ->required(),

                        Forms\Components\Select::make('city_id')
                            ->relationship('cities', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TimePicker::make('open_time_at')
                            ->required()
                            ->seconds(false),

                        Forms\Components\TimePicker::make('closed_time_at')
                            ->required()
                            ->seconds(false),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                //relationship
                Tables\Columns\TextColumn::make('cities.name'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('about'),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean()
                    ->label('Popular'),
            ])
            ->filters([
                //Memilih berdasarkan kota
                SelectFilter::make('cities_id')
                    ->label('City')
                    //relationship
                    ->relationship('cities', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListGyms::route('/'),
            'create' => Pages\CreateGym::route('/create'),
            'edit' => Pages\EditGym::route('/{record}/edit'),
        ];
    }
}
