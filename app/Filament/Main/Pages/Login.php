<?php

namespace App\Filament\Main\Pages;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class Login extends \Filament\Auth\Pages\Login
{
    protected Width|string|null $maxWidth = Width::Medium;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent()
                    ->prefixIcon(LucideIcon::Mail)
                    ->placeholder('Email')
                    ->hiddenLabel(),
                $this->getPasswordFormComponent()
                    ->prefixIcon(LucideIcon::KeyRound)
                    ->placeholder('Password')
                    ->hiddenLabel(),
                $this->getRememberFormComponent(),
            ]);
    }
}
