<?php

use App\Models\RoleModel;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new RoleModel;

        if ($model->count() == 0) {
            $model->insert([
                [
                    'name'    => 'Administrador',
                    'role'    => 'ADMINISTRATOR',
                    'modules' => 'user,client,supplier,product,category,subcategory,pdv,order,chargeback,report,graph',
                ],
                [
                    'name'    => 'Gestor',
                    'role'    => 'MANAGER',
                    'modules' => 'client,supplier,product,category,subcategory,order,chargeback,report,graph',
                ],
                [
                    'name'    => 'Gerente',
                    'role'    => 'SUPERVISOR',
                    'modules' => 'client,supplier,product,category,subcategory,order,chargeback,report,graph',
                ],
                [
                    'name'    => 'Operador',
                    'role'    => 'OPERATOR',
                    'modules' => 'client,pdv,order,chargeback',
                ],
            ]);
        }
    }
}
