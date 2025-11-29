<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TextInput::configureUsing(function (TextInput $textInput) {
            $textInput->hiddenLabel();
        });

        Select::configureUsing(function (Select $select) {
            $select->hiddenLabel();
        });

        TagsInput::configureUsing(function (TagsInput $tagsInput) {
            $tagsInput->hiddenLabel();
        });

        DatePicker::configureUsing(function (DatePicker $datePicker) {
            $datePicker->hiddenLabel();
        });

        TimePicker::configureUsing(function (TimePicker $timePicker) {
            $timePicker->hiddenLabel();
        });

        DateTimePicker::configureUsing(function (DateTimePicker $dateTimePicker) {
            $dateTimePicker->hiddenLabel();
        });

        DatePicker::configureUsing(function (DatePicker $datePicker) {
            $datePicker->hiddenLabel();
        });

        MarkdownEditor::configureUsing(function (MarkdownEditor $markdownEditor) {
            $markdownEditor->hiddenLabel();
        });

        CodeEditor::configureUsing(function (CodeEditor $codeEditor) {
            $codeEditor->hiddenLabel();
        });

        Table::configureUsing(function (Table $table) {
            $table->persistSearchInSession()
                ->persistFiltersInSession()
                ->persistSortInSession();
        });

        TextColumn::configureUsing(function (TextColumn $textColumn) {
            $textColumn->placeholder('-')
                ->searchable()
                ->sortable();
        });

        IconColumn::configureUsing(function (IconColumn $iconColumn) {
            $iconColumn->searchable()
                ->sortable();
        });

        CreateAction::configureUsing(function (CreateAction $createAction) {
            $createAction->stickyModalHeader()
                ->stickyModalFooter();
        });

        EditAction::configureUsing(function (EditAction $editAction) {
            $editAction->stickyModalHeader()
                ->stickyModalFooter();
        });
    }
}
