<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PropertyListTest extends DuskTestCase
{
    public function testShowsCornerCount(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dusk/properties')
                ->assertSee('corner_count=');
        });
    }
}
