<?php

namespace App\Console\Commands;

use App\Models\Person;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestFirstOrNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:first-or-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test firstOrNew() bug';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!Schema::hasTable('people'))
        {
            Artisan::call('migrate');

            DB::table('people')->insert(['name' => 'Jon', 'surname' => 'Doe']);
            DB::table('people')->insert(['name' => 'Jane', 'surname' => 'Doe']);

            DB::table('addresses')->insert(['address_line' => 'First street', 'postal_code' => 12345]);
            DB::table('addresses')->insert(['address_line' => 'Last street', 'postal_code' => 98765]);

            DB::table('address_person')->insert(['address_id' => 1, 'person_id' => 1]);
            DB::table('address_person')->insert(['address_id' => 2, 'person_id' => 1]);
        }

        $person1 = Person::query()->findOrFail(1);
        $person2 = Person::query()->findOrFail(2);

        $address1 = $person1->addresses()->first();
        $address2 = $person2->addresses()->first();
        $address3 = $person2->addresses()->firstOrNew();

        $this->output->success("first() returned address {$address1->id} from person 1");

        if($address2 === null)
        {
            $this->output->success("first() returned null for person 2");
        }

        if($address3->exists)
        {
            $this->output->error("firstOrNew() returned address {$address3->id} for person 2");
        }
        else
        {
            $this->output->success('firstOrNew() returned a new address for person');
        }

        return 0;
    }
}
