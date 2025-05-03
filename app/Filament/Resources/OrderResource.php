<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\OrderStatus;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    public static function getNavigationSort(): ?int
    {
        return 3;
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('status')
                        ->label('Order Status')
                        ->options([
                            OrderStatus::Pending->value => 'Pending',
                            OrderStatus::Processing->value => 'Processing',
                            OrderStatus::Shipped->value => 'Shipped',
                            OrderStatus::Delivered->value => 'Delivered',
                            OrderStatus::Cancelled->value => 'Cancelled',
                        ])
                        ->required()
                        ->native(false),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row')
                    ->label('No.')
                    ->rowIndex(),
                TextColumn::make('tracking_code')
                    ->label('Tracking Code')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state->value ?? $state)
                    ->colors([
                        'warning' => fn($state) => in_array($state->value ?? $state, [OrderStatus::Pending->value, OrderStatus::Processing->value]),
                        'success' => fn($state) => in_array($state->value ?? $state, [OrderStatus::Shipped->value, OrderStatus::Delivered->value]),
                        'danger' => fn($state) => in_array($state->value ?? $state, [OrderStatus::Cancelled->value]),
                    ])
                    ->icon(fn($state) => match ($state->value ?? $state) {
                        OrderStatus::Pending->value => 'heroicon-o-clock',
                        OrderStatus::Processing->value => 'heroicon-o-cog-6-tooth',
                        OrderStatus::Shipped->value => 'heroicon-o-truck',
                        OrderStatus::Delivered->value => 'heroicon-o-check-circle',
                        OrderStatus::Cancelled->value => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('cart.discount.code')
                    ->label('Discount Code')
                    ->placeholder('No discount'),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                // View action to see order details
                ViewAction::make()
                    ->iconButton(),

                // Update status action
                Action::make('updateStatus')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->iconButton()
                    ->modalHeading('Update Order Status')
                    ->form([
                        Select::make('status')
                            ->label('Order Status')
                            ->options([
                                OrderStatus::Pending->value => 'Pending',
                                OrderStatus::Processing->value => 'Processing',
                                OrderStatus::Shipped->value => 'Shipped',
                                OrderStatus::Delivered->value => 'Delivered',
                                OrderStatus::Cancelled->value => 'Cancelled',
                            ])
                            ->required()
                            ->native(false)
                            ->default(fn(Order $record) => $record->status->value ?? $record->status),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $oldStatus = $record->status->value ?? $record->status;
                        $record->status = $data['status'];
                        $record->save();

                        Notification::make()
                            ->title('Order status updated')
                            ->body("Order #{$record->tracking_code} status changed from {$oldStatus} to {$data['status']}")
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        OrderStatus::Pending->value => 'Pending',
                        OrderStatus::Processing->value => 'Processing',
                        OrderStatus::Shipped->value => 'Shipped',
                        OrderStatus::Delivered->value => 'Delivered',
                        OrderStatus::Cancelled->value => 'Cancelled',
                    ]),
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
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function infolist( $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        TextEntry::make('tracking_code')
                            ->label('Tracking Code')
                            ->copyable(),

                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 2,
                        ])
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Order Status')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => $state->value ?? $state)
                                    ->color(fn(Order $record) => match ($record->status->value ?? $record->status) {
                                        OrderStatus::Pending->value, OrderStatus::Processing->value => 'warning',
                                        OrderStatus::Shipped->value, OrderStatus::Delivered->value => 'success',
                                        OrderStatus::Cancelled->value => 'danger',
                                        default => 'secondary'
                                    }),

                                TextEntry::make('total_amount')
                                    ->label('Total Amount')
                                    ->money('USD'),

                                TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->dateTime(),

                                TextEntry::make('discount.code')
                                    ->label('Discount Applied')
                                    ->placeholder('No discount')
                                    ->badge()
                                    ->color('primary')
                                    ->visible(fn(Order $record) => $record->discount_id !== null),
                            ]),
                    ]),

                Section::make('Customer Details')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Customer Name'),
                        TextEntry::make('user.email')
                            ->label('Customer Email')
                            ->copyable(),
                        TextEntry::make('shipping_address')
                            ->label('Shipping Address')
                            ->markdown(),
                    ])
                    ->columns(2),

                Section::make('Order Items')
                    ->schema([
                        RepeatableEntry::make('cart.items')
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Product'),
                                TextEntry::make('quantity')
                                    ->label('Quantity'),
                                TextEntry::make('product.price')
                                    ->label('Unit Price')
                                    ->money('USD'),
                                TextEntry::make('line_total')
                                    ->label('Line Total')
                                    ->money('USD')
                                    ->getStateUsing(fn($record) => $record->quantity * $record->product->price),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }

}
