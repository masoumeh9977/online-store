<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselItemResource\Pages;
use App\Filament\Resources\CarouselItemResource\RelationManagers;
use App\Models\CarouselItem;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarouselItemResource extends Resource
{
    protected static ?string $model = CarouselItem::class;


    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationSort(): ?int
    {
        return 6;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Carousel Item Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('text')
                                    ->rows(3)
                                    ->maxLength(1000),
                            ]),

                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Image')
                            ->collection('carousel_images')
                            ->image()
                            ->imagePreviewHeight('250')
                            ->preserveFilenames()
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('carousel_images'))
                    ->circular()
                    ->height(60)
                    ->width(60),

                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('text')->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCarouselItems::route('/'),
            'create' => Pages\CreateCarouselItem::route('/create'),
            'edit' => Pages\EditCarouselItem::route('/{record}/edit'),
        ];
    }
}
