<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(TagSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(PaymentMethodSeeder::class);
        // $this->call(CustomerSeeder::class);
        // $this->call(OrderSeeder::class);
        //$this->call(ProductTagSeeder::class);
    }
}
