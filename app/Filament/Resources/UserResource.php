<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->description('Basic user account details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                            ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                            ->hiddenOn('edit')
                            ->maxLength(255),

                        TextInput::make('mobile')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->maxLength(20),
                    ]),

                Section::make('User Role')
                    ->description('Assign permissions to the user')
                    ->schema([
                        Select::make('roles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable(),
                    ]),

                Section::make('Location Information')
                    ->description('User address details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('province_id')
                                    ->label('Province')
                                    ->options(IranProvince::all()->pluck('name', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('city_id', null)),

                                Select::make('city_id')
                                    ->label('City')
                                    ->options(function (callable $get) {
                                        $province = IranProvince::find($get('province_id'));
                                        return $province?->cities()->pluck('name', 'id') ?? [];
                                    }),
                            ]),

                        Textarea::make('address')
                            ->rows(3)
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mobile')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Roles')
                    ->separator(','),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
