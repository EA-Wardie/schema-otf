<?php

namespace App\Filament\Main\Pages;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class Register extends \Filament\Auth\Pages\Register
{
    protected Width|string|null $maxWidth = Width::Medium;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent()
                    ->prefixIcon(LucideIcon::User)
                    ->placeholder('Name')
                    ->hiddenLabel(),
                $this->getEmailFormComponent()
                    ->prefixIcon(LucideIcon::Mail)
                    ->placeholder('Email')
                    ->hiddenLabel(),
                $this->getPasswordFormComponent()
                    ->prefixIcon(LucideIcon::KeyRound)
                    ->placeholder('Password')
                    ->hiddenLabel(),
                $this->getPasswordConfirmationFormComponent()
                    ->prefixIcon(LucideIcon::KeyRound)
                    ->placeholder('Confirm Password')
                    ->hiddenLabel(),
            ]);
    }
}
