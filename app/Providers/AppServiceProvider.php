<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
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
            $textInput->hiddenLabel()
                ->placeholder($textInput->getLabel());
        });

        Select::configureUsing(function (Select $select) {
            $select->hiddenLabel()
                ->placeholder($select->getLabel());
        });

        TagsInput::configureUsing(function (TagsInput $tagsInput) {
            $tagsInput->hiddenLabel()
                ->placeholder($tagsInput->getLabel());
        });

        DatePicker::configureUsing(function (DatePicker $datePicker) {
            $datePicker->hiddenLabel()
                ->placeholder($datePicker->getLabel());
        });

        TimePicker::configureUsing(function (TimePicker $timePicker) {
            $timePicker->hiddenLabel()
                ->placeholder($timePicker->getLabel());
        });

        DateTimePicker::configureUsing(function (DateTimePicker $dateTimePicker) {
            $dateTimePicker->hiddenLabel()
                ->placeholder($dateTimePicker->getLabel());
        });

        MarkdownEditor::configureUsing(function (MarkdownEditor $markdownEditor) {
            $markdownEditor->hiddenLabel()
                ->placeholder($markdownEditor->getLabel());
        });

        CodeEditor::configureUsing(function (CodeEditor $codeEditor) {
            $codeEditor->hiddenLabel();
        });

        Toggle::configureUsing(function (Toggle $toggle): void {
            $toggle->columnSpanFull();
        });

        Table::configureUsing(function (Table $table) {
            $table->paginationPageOptions([10, 25, 50, 100])
                ->defaultPaginationPageOption(50)
                ->persistSearchInSession()
                ->persistFiltersInSession()
                ->persistSortInSession();
        });

        TextColumn::configureUsing(function (TextColumn $textColumn) {
            $textColumn->placeholder('-')
                ->searchable()
                ->sortable();
        });

        IconColumn::configureUsing(function (IconColumn $iconColumn) {
            $iconColumn->searchable(false)
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

        ViewAction::configureUsing(function (ViewAction $viewAction) {
            $viewAction->stickyModalHeader()
                ->stickyModalFooter();
        });
    }
}
