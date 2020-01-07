<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            CodeListSeeder::class,
            CountrySeeder::class,
            RoleSeeder::class,
            InstitutionSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            RootClassSeeder::class,
            RootSeeder::class,
            WordTypeSeeder::class,
            WordSeeder::class,
            NotificationsSeeder::class,
            JobSeeder::class,
            IdiomSeeder::class,
            WordActivitySeeder::class,
            ApproximateDatesSeeder::class,
            ErasSeeder::class,
            CitationSeeder::class,
            RelatedCitationDataSeeder::class,
            StatusSeeder::class,
            NounNatureRelationSeeder::class,
            ScientificDomainSeeder::class,
            WordActivitySeeder::class,
            CitationActivitySeeder::class
        ]);

    }
}
