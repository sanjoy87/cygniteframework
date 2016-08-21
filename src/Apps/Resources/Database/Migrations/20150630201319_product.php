<?php
use Cygnite\Database\Migration;
use Cygnite\Database\Table\Schema;

/**
* This file is generated by Cygnite Migration Command
* You may use up and down method to create migration
*/

class Product extends Migration
{
    /**
     * Specify your database connection name here
     *
     * @var string
     */
    protected $database = 'cygnite';
    /**
     * Run the migrations up.
     *
     * @return void
     */
    public function up()
    {
        //Your schema to migrate
        Schema::make($this, function ($table) {
            $table->tableName = 'product';

            $table->create(
                [
                    ['column'=> 'id', 'type' => 'int', 'length' => 11,
                        'increment' => true, 'key' => 'primary'],
                    ['column'=> 'product_name', 'type' => 'string', 'length' =>100],
                    ['column'=> 'category', 'type' => 'string', 'length' =>150],
                    ['column'=> 'description', 'type' => 'string', 'length'  =>255],
                    ['column'=> 'validity', 'type' => 'date', 'length'  =>'0000-00-00'],
                    ['column'=> 'price', 'type' => 'decimal', 'length'  =>'10,2'],
                    ['column'=> 'created_at', 'type' => 'datetime'],
                    ['column'=> 'updated_at', 'type' => 'datetime'],

                ], 'InnoDB', 'latin1'
            )->run();
        });

        $data = [
            'product_name' => 'Apple Iphone6',
            'category' => 'Electronic',
            'description' => 'Hugely powerful. Enormously efficient.',
            'validity' => '2018-08-30',
            'price' => '950.00',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->insert('product', $data);
    }

    /**
     * Revert back your migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->delete('product', '1'); // delete last seeded data
        //Roll back your changes done by up method.
        Schema::make($this, function ($table) {
            $table->tableName = 'product';
            $table->drop()->run();
        });
    }
}// End of the Migration
