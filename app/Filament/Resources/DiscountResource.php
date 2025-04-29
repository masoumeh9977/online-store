<?php

namespace App\Filament\Resources;

use App\DiscountType;
use App\Filament\Resources\DiscountResource\Pages;
use App\Models\Discount;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Discount Configuration')
                    ->description('Set up the basic discount details')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Card::make()
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Discount Code')
                                            ->unique(ignoreRecord: true)
                                            ->required()
                                            ->placeholder('SUMMER2025')
                                            ->maxLength(50)
                                            ->columnSpan(1),

                                        Select::make('type')
                                            ->label('Discount Type')
                                            ->options([
                                                DiscountType::Percentage->value => 'Percentage (%)',
                                                DiscountType::Fixed->value => 'Fixed Amount ($)',
                                            ])
                                            ->required()
                                            ->native(false)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),

                                TextInput::make('value')
                                    ->label('Discount Value')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0.01)
                                    ->step(0.01)
                                    ->prefix(fn($get) => $get('type') === DiscountType::Percentage->value ? '%' : '$')
                                    ->helperText(fn($get) => $get('type') === DiscountType::Percentage->value
                                        ? 'Enter percentage discount (e.g. 10 for 10%)'
                                        : 'Enter fixed amount discount in dollars')
                                    ->columnSpan('full'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Usage Restrictions')
                    ->description('Configure when and how this discount can be used')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        Card::make()
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextInput::make('max_usage')
                                            ->label('Maximum Usage')
                                            ->numeric()
                                            ->nullable()
                                            ->placeholder('Unlimited')
                                            ->suffix('uses')
                                            ->columnSpan(1),

                                        DateTimePicker::make('expires_at')
                                            ->label('Expires At')
                                            ->nullable()
                                            ->placeholder('Never expires')
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),

                                Toggle::make('is_active')
                                    ->label('Is Active?')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->default(true)
                                    ->columnSpan('full'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Eligible Users')
                    ->description('Associate specific users with this discount code')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Card::make()
                            ->schema([
                                Repeater::make('discountUsers')
                                    ->relationship()
                                    ->schema([
                                        Select::make('user_id')
                                            ->label('User')
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->required()
                                            ->columnSpan('full'),
                                    ])
                                    ->columns(1)
                                    ->itemLabel(fn(array $state): ?string => User::find($state['user_id'] ?? null)?->name ?? 'New User Association'
                                    )
                                    ->createItemButtonLabel('Add User')
                                    ->defaultItems(0)
                                    ->columnSpan('full'),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Discount Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('used_count')
                    ->label('Usage')
                    ->sortable()
                    ->formatStateUsing(fn($state, $record) => $record->max_usage ? "{$state} / {$record->max_usage}" : $state
                    ),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never')
                    ->color(fn($record) => $record->expires_at && $record->expires_at->isPast() ? 'danger' : null
                    ),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),

                Tables\Filters\Filter::make('expires_at')
                    ->form([
                        DatePicker::make('expires_until')
                            ->label('Expires before'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['expires_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('expires_at', '<=', $date)
                        );
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->color('primary')
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('duplicate')
                    ->iconButton()
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Discount $record) {
                        $newDiscount = $record->replicate();
                        $newDiscount->code = $record->code . '_COPY';
                        $newDiscount->save();

                        Notification::make()
                            ->title('Discount duplicated')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Discount Details')
                    ->schema([
                        TextEntry::make('code')
                            ->label('Discount Code')
                            ->copyable()
                            ->badge(),

                        Group::make([
                            TextEntry::make('type')
                                ->label('Type')
                                ->badge()
                                ->formatStateUsing(fn($state): string => $state === DiscountType::Percentage->value || $state == DiscountType::Percentage->value
                                    ? 'Percentage (%)'
                                    : 'Fixed Amount ($)'),

                            TextEntry::make('value')
                                ->label('Value')
                                ->formatStateUsing(fn($state, Discount $record): string => ($record->type === DiscountType::Percentage->value || $record->type == DiscountType::Percentage->value)
                                    ? "{$state}%"
                                    : "\${$state}"),
                        ])->columns(2),
                    ]),

                \Filament\Infolists\Components\Section::make('Usage Information')
                    ->schema([
                        TextEntry::make('used_count')
                            ->label('Current Usage')
                            ->formatStateUsing(fn($state, $record) => $record->max_usage ? "{$state} / {$record->max_usage}" : $state),

                        TextEntry::make('is_active')
                            ->label('Status')
                            ->badge()
                            ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'Inactive'),

                        TextEntry::make('expires_at')
                            ->label('Expiration Date')
                            ->dateTime()
                            ->placeholder('Never expires')
                            ->color(fn($record) => $record->expires_at && $record->expires_at->isPast() ? 'danger' : null),
                    ])
                    ->columns(2),

                \Filament\Infolists\Components\Section::make('Eligible Users')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('users_display')
                            ->label('Associated Users')
                            ->getStateUsing(function (Discount $record) {
                                $users = $record->users()->get();
                                if ($users->isEmpty()) {
                                    return 'No users assigned';
                                }

                                return implode("\n", $users->map(function ($user) {
                                    return $user->name . ' (' . $user->email . ')';
                                })->toArray());
                            }),
                    ])
                    ->collapsed(),

                \Filament\Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
