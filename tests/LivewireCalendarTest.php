<?php

namespace Asantibanez\LivewireCalendar\Tests;

use Asantibanez\LivewireCalendar\LivewireCalendar;
use Livewire\LivewireManager;
use Livewire\Testing\TestableLivewire;

class LivewireCalendarTest extends TestCase
{
    private function createComponent($parameters = []): TestableLivewire
    {
        return app(LivewireManager::class)->test(LivewireCalendar::class, $parameters);
    }

    public function test_can_build_component(): void
    {
        $component = $this->createComponent([]);

        $this->assertNotNull($component);
    }

    public function test_can_navigate_to_next_month(): void
    {
        $component = $this->createComponent([]);

        $component->runAction('goToNextMonth');

        $this->assertEquals(
            today()->startOfMonth()->addMonthNoOverflow(),
            $component->get('startsAt')
        );

        $this->assertEquals(
            today()->endOfMonth()->startOfDay()->addMonthNoOverflow(),
            $component->get('endsAt')
        );
    }

    public function test_can_navigate_to_previous_month(): void
    {
        $component = $this->createComponent([]);

        $component->runAction('goToPreviousMonth');

        $this->assertEquals(
            today()->startOfMonth()->subMonthNoOverflow(),
            $component->get('startsAt')
        );

        $this->assertEquals(
            today()->endOfMonth()->startOfDay()->subMonthNoOverflow(),
            $component->get('endsAt')
        );
    }

    public function test_can_navigate_to_current_month(): void
    {
        $component = $this->createComponent([]);

        $component->runAction('goToPreviousMonth');
        $component->runAction('goToPreviousMonth');
        $component->runAction('goToPreviousMonth');

        $component->runAction('goToCurrentMonth');

        $this->assertEquals(
            today()->startOfMonth(),
            $component->get('startsAt')
        );

        $this->assertEquals(
            today()->endOfMonth()->startOfDay(),
            $component->get('endsAt')
        );
    }
}
