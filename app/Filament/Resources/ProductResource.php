<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Product Information')
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required(),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('price')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required(),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('category_id')
                                            ->required()
                                            ->label('Category')
                                            ->options(Category::all()->pluck('name', 'id')),

                                        Toggle::make('is_active')
                                            ->inline(false)
                                            ->default(true),
                                    ]),

                                Textarea::make('description'),
                            ]),
                        Section::make('Product Image')
                            ->columnSpan(1) // Span 1 column
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Upload Image')
                                    ->image()
                                    ->directory('products')
                                    ->imagePreviewHeight('300')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'active' : 'not-active')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(bool $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                    }),
                TextColumn::make('category.name')
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
