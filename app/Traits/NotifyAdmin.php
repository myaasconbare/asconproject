<?php

namespace App\Traits;

use App\Enums\AdminNotificationChannels;
use App\Enums\AdminNotificationTypes;
use App\Models\Admin;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

trait NotifyAdmin
{
    public function notifyAdmin($channel, $type, $record, $body = null)
    {
        Admin::all()
            ->each(function ($admin) use ($channel, $type, $record) {
                return match ($channel) {
                    AdminNotificationChannels::DASHBOARD => $this->notifyAdminViaDashboard($admin, $record, $type, $body),
                    AdminNotificationChannels::MAIL => $this->notifyAdminViaMail($admin, $record, $type),
                };
            });
    }

    public function notifyAdminViaDashboard($type, $body, $url = null)
    {
        $title = AdminNotificationTypes::title($type);

        Admin::all()
            ->each(function ($admin) use ($body, $url, $title) {
                $admin->notify(
                    Notification::make()
                        ->title($title)
                        ->body($body)
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->outlined()
                                ->color('info')
                                ->url($url),
                            Action::make('mark as read')
                                ->button()
                                ->outlined()
                                ->color('success')
                                ->markAsRead(),
                            Action::make('mark as unread')
                                ->button()
                                ->outlined()
                                ->color('danger')
                                ->markAsUnread(),
                        ])->toDatabase()
                );
            });
    }

    public function notifyAdminViaMail($admin, $record, $type) {}
}
