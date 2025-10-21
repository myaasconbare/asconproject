<?php

namespace App\Filament\Resources;

use App\Filament\Pages\News;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Traits\Admin\Notify;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    use Notify;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('firstname'),
                TextInput::make('lastname'),
                TextInput::make('email'),
                TextInput::make('country'),
                TextInput::make('phone'),
                TextInput::make('address'),

                TextInput::make('deposit_wallet')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),
                TextInput::make('interest_wallet')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),
                TextInput::make('residual_wallet')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),
                TextInput::make('total_invested')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),
                TextInput::make('total_earned')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),
                TextInput::make('total_withdrawan')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->default(0.00),

                TextInput::make('total_referrals')
                    ->numeric()
                    ->default(0),

            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('Image')
                    ->circular(),
                TextColumn::make('name')
                    ->label('user')
                    ->searchable(['email', 'name'])
                    ->description(fn(Model $record) => $record->email),

                TextColumn::make('fullname')
                    ->label('Full name')
                    // ->suffix(fn(Model $record) => " " . $record->lastname)
                    ->searchable(['firstname', 'lastname']),

                TextColumn::make('phone')
                    ->description(fn(Model $record) => $record->country)
                    ->searchable(['phone', 'country']),
                TextColumn::make('rank')
                    ->state(fn(User $record) => "Level {$record->rank?->level} : {$record->rank?->name}"),
                TextColumn::make('deposit_wallet')
                    ->searchable()
                    ->money('USD'),
                TextColumn::make('interest_wallet')
                    ->default(0.00)
                    ->searchable()
                    ->money('USD'),
                TextColumn::make('residual_wallet')
                    ->money('USD'),

            ])
            ->filters([
                // SelectFilter::make('rank_id')
                //     ->label('Rank')
                //     ->options(Rank::pluck('name', 'id')),
            ])
            ->actions([
                Action::make('manageUser')
                    ->label('Balance')
                    ->outlined()
                    ->button()
                    ->color('info')
                    ->modalHeading('Manage User')
                    ->form([
                        Section::make('Primary Wallets')
                            ->schema([
                                Grid::make(3)
                                ->schema([
                                    TextInput::make('deposit_wallet')
                                        ->placeholder('Enter volume')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('interest_wallet')
                                        ->placeholder('Enter reward')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('residual_wallet')
                                        ->placeholder('Enter reward')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                ])
                            ]),
                        Section::make('Other Balances')
                            ->schema([
                                Grid::make(3)
                                ->schema([
                                    TextInput::make('trade_wallet')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('trade_practice_wallet')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                                    TextInput::make('total_invested')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('total_profits')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('running_investment')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                                    TextInput::make('matrix_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('matrix_referral_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('matrix_level_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                
                                    TextInput::make('total_trading')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('winning_amount')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('loss_amount')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                                    TextInput::make('total_deposited')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('total_withdrawn')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                                    TextInput::make('investment_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('referral_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('level_commission')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                
                                    TextInput::make('direct_team_volume')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('total_team_volume')
                                        ->prefix('$')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->numeric()
                                        ->columnSpan(1)
                                        ->required(),
                                ])
                            ])
                    ])
                    // ->mountUsing(function (Form $form, Model $record) {
                        // $form->fill();
                        // $form->fill($record->toArray());
                 
                        // ...
                    // })
                   
                    ->fillForm(fn (Model $record) => $record->toArray())
                    // ->disabledForm()
                    ->action(function (Model $record, array $data): void {
                        $record->update($data);
                        (new self)->notify('success', 'Updated successfully');
                    }),
                
                ActionGroup::make([
                    Action::make('view')
                        ->action(function (User $user) {
                            return redirect(ViewUser::getUrl(['record' => $user->id]));
                        }),
                    Action::make('dashboard')
                        ->action(function (User $user) {

                            auth('web')->login($user);

                            session()->put('view_details', [
                                'referrer_page' => self::getUrl(),
                                'user_id' => auth('web')->id(),
                                'admin_id' => auth('admin')->id(),
                            ]);

                            session(['two_factor_verified' => true]);

                            to_route('user.dashboard');
                        }),
                    Action::make('send email')
                        ->action(function (User $user) {
                            return redirect(News::getUrl(['user_id' => $user->id]));
                        }),

                    // Action::make('make marketer')
                    // ->requiresConfirmation()
                    // ->action(function (User $user) {

                    //     $user->update(['is_marketer' => true]);

                    //     Notification::make()
                    //         ->title('success')
                    //         ->body('User been succesfully made a marketer')
                    //         ->icon('heroicon-o-check-circle')
                    //         ->iconColor('success')
                    //         ->send();
                    // })
                    // ->visible(fn (User $user) => !$user->is_marketer),

                    // Action::make('remove marketer')
                    //     ->requiresConfirmation()
                    //     ->action(function (User $user) {

                    //         $user->update(['is_marketer' => false]);

                    //         Notification::make()
                    //             ->title('success')
                    //             ->body('User been succesfully removed as marketer')
                    //             ->icon('heroicon-o-check-circle')
                    //             ->iconColor('success')
                    //             ->send();
                    //     })
                    //     ->visible(fn (User $user) => $user->is_marketer),


                    Action::make('suspend')
                        ->requiresConfirmation()
                        ->action(function (User $user) {

                            $user->update(['is_suspended' => true]);

                            Notification::make()
                                ->title('success')
                                ->body('User suspended succesfully')
                                ->icon('heroicon-o-check-circle')
                                ->iconColor('success')
                                ->send();

                            // ->body()
                            // ->delete
                        })
                        ->visible(fn(User $user) => !$user->is_suspended),
                    Action::make('unsuspend')
                        ->requiresConfirmation()
                        ->action(function (User $user) {

                            $user->update(['is_suspended' => false]);

                            Notification::make()
                                ->title('success')
                                ->body('User unsuspended succesfully')
                                ->icon('heroicon-o-check-circle')
                                ->iconColor('success')
                                ->send();

                            // ->body()
                            // ->delete
                        })
                        ->visible(fn(User $user) => $user->is_suspended),
                    Action::make('Disable TwoFactor')
                        ->requiresConfirmation()
                        ->action(function (User $user) {

                            $user->update([
                                'is_2fa_enabled' =>  true,
                                '2fa_secret' => null,
                            ]);

                            Notification::make()
                                ->title('success')
                                ->body('TwoFactor succesfully disabled for user')
                                ->icon('heroicon-o-check-circle')
                                ->iconColor('success')
                                ->send();
                        })
                        ->visible(fn(User $record) => $record->twoFactorSecurity ? !$record->twoFactorSecurity->is_disabled : false),
                    DeleteAction::make()
                ])

                    ->color('success')
                    ->button(),
                Action::make('change password')
                
                    // ->label(function(User $record) {
                    //     return "Change Password for " . $record->username;
                    // })
                    ->form(function (User $record) {
                        return [
                            TextInput::make('email')
                                ->default($record->email)
                                // ->state()
                                // ->disabled()
                                ->readOnly(),
                            TextInput::make('password')
                                ->required()
                                ->label('Password')
                                ->autocomplete(false)
                                ->confirmed()
                                ->default('')
                                ->placeholder('Enter new password')
                                ->password()
                                ->revealable(),
                            TextInput::make('password_confirmation')
                                ->autocomplete(false)
                                ->required()
                                ->default('')
                                ->label('Repeat password')
                                ->placeholder('Repeat new password')
                                ->password()
                                ->revealable()
                        ];
                    })
                    ->action(function (array $data, User $record): void {
                        $record->password = $data['password'];
                        $record->save();

                        Notification::make()
                            ->title('success')
                            ->body('Password updated succesfully for ' . $record->username)
                            ->icon('heroicon-o-check-circle')
                            ->iconColor('success')
                            ->send();
                    })
                    ->button()
                    ->color('warning')
                    ->outlined()
                    // ->color('info')
                    ->modalWidth('md')
                    ->modalHeading((function (User $record) {
                        return "Change Password for " . $record->username;
                    }))

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
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}/view'),
            'view-user' => Pages\ViewUsers::route('/{record}/view-user'),

        ];
    }
}
