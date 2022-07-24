<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission')->delete();
        
        \DB::table('permission')->insert(array (
            0 => 
            array (
                'id' => 1,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'modules',
                'action' => 'index',
            ),
            1 => 
            array (
                'id' => 2,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'modules',
                'action' => 'create',
            ),
            2 => 
            array (
                'id' => 3,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'modules',
                'action' => 'update',
            ),
            3 => 
            array (
                'id' => 4,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'modules',
                'action' => 'view',
            ),
            4 => 
            array (
                'id' => 5,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'modules',
                'action' => 'delete',
            ),
            5 => 
            array (
                'id' => 6,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'modules',
                'action' => 'isactive',
            ),
            6 => 
            array (
                'id' => 7,
                'module_id' => 3,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'modules',
                'action' => 'export',
            ),
            7 => 
            array (
                'id' => 8,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'permission',
                'action' => 'index',
            ),
            8 => 
            array (
                'id' => 9,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'permission',
                'action' => 'create',
            ),
            9 => 
            array (
                'id' => 10,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'permission',
                'action' => 'update',
            ),
            10 => 
            array (
                'id' => 11,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'permission',
                'action' => 'view',
            ),
            11 => 
            array (
                'id' => 12,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'permission',
                'action' => 'delete',
            ),
            12 => 
            array (
                'id' => 13,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'permission',
                'action' => 'isactive',
            ),
            13 => 
            array (
                'id' => 14,
                'module_id' => 4,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'permission',
                'action' => 'export',
            ),
            14 => 
            array (
                'id' => 15,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'role',
                'action' => 'index',
            ),
            15 => 
            array (
                'id' => 16,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'role',
                'action' => 'create',
            ),
            16 => 
            array (
                'id' => 17,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'role',
                'action' => 'update',
            ),
            17 => 
            array (
                'id' => 18,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'role',
                'action' => 'view',
            ),
            18 => 
            array (
                'id' => 19,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'role',
                'action' => 'delete',
            ),
            19 => 
            array (
                'id' => 20,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'role',
                'action' => 'isactive',
            ),
            20 => 
            array (
                'id' => 21,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'role',
                'action' => 'export',
            ),
            21 => 
            array (
                'id' => 22,
                'module_id' => 5,
                'panel' => 'Backend',
                'title' => 'Access',
                'name' => 'access',
                'controller' => 'role',
                'action' => 'index',
            ),
            22 => 
            array (
                'id' => 23,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'emailtemplates',
                'action' => 'index',
            ),
            23 => 
            array (
                'id' => 24,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'emailtemplates',
                'action' => 'create',
            ),
            24 => 
            array (
                'id' => 25,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'emailtemplates',
                'action' => 'update',
            ),
            25 => 
            array (
                'id' => 26,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'emailtemplates',
                'action' => 'view',
            ),
            26 => 
            array (
                'id' => 27,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'emailtemplates',
                'action' => 'delete',
            ),
            27 => 
            array (
                'id' => 28,
                'module_id' => 7,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'emailtemplates',
                'action' => 'isactive',
            ),
            28 => 
            array (
                'id' => 29,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'settings',
                'action' => 'index',
            ),
            29 => 
            array (
                'id' => 30,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'settings',
                'action' => 'create',
            ),
            30 => 
            array (
                'id' => 31,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'settings',
                'action' => 'update',
            ),
            31 => 
            array (
                'id' => 32,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'settings',
                'action' => 'view',
            ),
            32 => 
            array (
                'id' => 33,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'settings',
                'action' => 'delete',
            ),
            33 => 
            array (
                'id' => 34,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'settings',
                'action' => 'isactive',
            ),
            34 => 
            array (
                'id' => 35,
                'module_id' => 8,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'settings',
                'action' => 'export',
            ),
            35 => 
            array (
                'id' => 36,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'custompages',
                'action' => 'index',
            ),
            36 => 
            array (
                'id' => 37,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'custompages',
                'action' => 'create',
            ),
            37 => 
            array (
                'id' => 38,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'custompages',
                'action' => 'update',
            ),
            38 => 
            array (
                'id' => 39,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'custompages',
                'action' => 'view',
            ),
            39 => 
            array (
                'id' => 40,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'custompages',
                'action' => 'delete',
            ),
            40 => 
            array (
                'id' => 41,
                'module_id' => 9,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'custompages',
                'action' => 'isactive',
            ),
            41 => 
            array (
                'id' => 42,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'user',
                'action' => 'index',
            ),
            42 => 
            array (
                'id' => 43,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'user',
                'action' => 'create',
            ),
            43 => 
            array (
                'id' => 44,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'user',
                'action' => 'update',
            ),
            44 => 
            array (
                'id' => 45,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'user',
                'action' => 'view',
            ),
            45 => 
            array (
                'id' => 46,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'user',
                'action' => 'delete',
            ),
            46 => 
            array (
                'id' => 47,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'user',
                'action' => 'isactive',
            ),
            47 => 
            array (
                'id' => 48,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'user',
                'action' => 'export',
            ),
            48 => 
            array (
                'id' => 49,
                'module_id' => 10,
                'panel' => 'Backend',
                'title' => 'Change Password',
                'name' => 'changepassword',
                'controller' => 'user',
                'action' => 'changepassword',
            ),
            49 => 
            array (
                'id' => 50,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'country',
                'action' => 'index',
            ),
            50 => 
            array (
                'id' => 51,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'country',
                'action' => 'create',
            ),
            51 => 
            array (
                'id' => 52,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'country',
                'action' => 'update',
            ),
            52 => 
            array (
                'id' => 53,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'country',
                'action' => 'view',
            ),
            53 => 
            array (
                'id' => 54,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'country',
                'action' => 'delete',
            ),
            54 => 
            array (
                'id' => 55,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'country',
                'action' => 'isactive',
            ),
            55 => 
            array (
                'id' => 56,
                'module_id' => 20,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'country',
                'action' => 'export',
            ),
            56 => 
            array (
                'id' => 57,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'state',
                'action' => 'index',
            ),
            57 => 
            array (
                'id' => 58,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'state',
                'action' => 'create',
            ),
            58 => 
            array (
                'id' => 59,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'state',
                'action' => 'update',
            ),
            59 => 
            array (
                'id' => 60,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'state',
                'action' => 'view',
            ),
            60 => 
            array (
                'id' => 61,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'state',
                'action' => 'delete',
            ),
            61 => 
            array (
                'id' => 62,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'state',
                'action' => 'isactive',
            ),
            62 => 
            array (
                'id' => 63,
                'module_id' => 21,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'state',
                'action' => 'export',
            ),
            63 => 
            array (
                'id' => 64,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'district',
                'action' => 'index',
            ),
            64 => 
            array (
                'id' => 65,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'district',
                'action' => 'create',
            ),
            65 => 
            array (
                'id' => 66,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'district',
                'action' => 'update',
            ),
            66 => 
            array (
                'id' => 67,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'district',
                'action' => 'view',
            ),
            67 => 
            array (
                'id' => 68,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'district',
                'action' => 'delete',
            ),
            68 => 
            array (
                'id' => 69,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'district',
                'action' => 'isactive',
            ),
            69 => 
            array (
                'id' => 70,
                'module_id' => 22,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'district',
                'action' => 'export',
            ),
            70 => 
            array (
                'id' => 71,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'subdistrict',
                'action' => 'index',
            ),
            71 => 
            array (
                'id' => 72,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'subdistrict',
                'action' => 'create',
            ),
            72 => 
            array (
                'id' => 73,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'subdistrict',
                'action' => 'update',
            ),
            73 => 
            array (
                'id' => 74,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'subdistrict',
                'action' => 'view',
            ),
            74 => 
            array (
                'id' => 75,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'subdistrict',
                'action' => 'delete',
            ),
            75 => 
            array (
                'id' => 76,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'subdistrict',
                'action' => 'isactive',
            ),
            76 => 
            array (
                'id' => 77,
                'module_id' => 23,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'subdistrict',
                'action' => 'export',
            ),
            77 => 
            array (
                'id' => 78,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'block',
                'action' => 'index',
            ),
            78 => 
            array (
                'id' => 79,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'block',
                'action' => 'create',
            ),
            79 => 
            array (
                'id' => 80,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'block',
                'action' => 'update',
            ),
            80 => 
            array (
                'id' => 81,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'block',
                'action' => 'view',
            ),
            81 => 
            array (
                'id' => 82,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'block',
                'action' => 'delete',
            ),
            82 => 
            array (
                'id' => 83,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'block',
                'action' => 'isactive',
            ),
            83 => 
            array (
                'id' => 84,
                'module_id' => 24,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'block',
                'action' => 'export',
            ),
            84 => 
            array (
                'id' => 85,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'village',
                'action' => 'index',
            ),
            85 => 
            array (
                'id' => 86,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'village',
                'action' => 'create',
            ),
            86 => 
            array (
                'id' => 87,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'village',
                'action' => 'update',
            ),
            87 => 
            array (
                'id' => 88,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'village',
                'action' => 'view',
            ),
            88 => 
            array (
                'id' => 89,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'village',
                'action' => 'delete',
            ),
            89 => 
            array (
                'id' => 90,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'village',
                'action' => 'isactive',
            ),
            90 => 
            array (
                'id' => 91,
                'module_id' => 25,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'village',
                'action' => 'export',
            ),
            91 => 
            array (
                'id' => 92,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'department',
                'action' => 'index',
            ),
            92 => 
            array (
                'id' => 93,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'department',
                'action' => 'create',
            ),
            93 => 
            array (
                'id' => 94,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'department',
                'action' => 'update',
            ),
            94 => 
            array (
                'id' => 95,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'department',
                'action' => 'view',
            ),
            95 => 
            array (
                'id' => 96,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'department',
                'action' => 'delete',
            ),
            96 => 
            array (
                'id' => 97,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'department',
                'action' => 'isactive',
            ),
            97 => 
            array (
                'id' => 98,
                'module_id' => 26,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'department',
                'action' => 'export',
            ),
            98 => 
            array (
                'id' => 99,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'category',
                'action' => 'index',
            ),
            99 => 
            array (
                'id' => 100,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'category',
                'action' => 'create',
            ),
            100 => 
            array (
                'id' => 101,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'category',
                'action' => 'update',
            ),
            101 => 
            array (
                'id' => 102,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'category',
                'action' => 'view',
            ),
            102 => 
            array (
                'id' => 103,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'category',
                'action' => 'delete',
            ),
            103 => 
            array (
                'id' => 104,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'category',
                'action' => 'isactive',
            ),
            104 => 
            array (
                'id' => 105,
                'module_id' => 27,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'category',
                'action' => 'export',
            ),
            105 => 
            array (
                'id' => 176,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'festival',
                'action' => 'index',
            ),
            106 => 
            array (
                'id' => 177,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'festival',
                'action' => 'create',
            ),
            107 => 
            array (
                'id' => 178,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'festival',
                'action' => 'update',
            ),
            108 => 
            array (
                'id' => 179,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'festival',
                'action' => 'view',
            ),
            109 => 
            array (
                'id' => 180,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'festival',
                'action' => 'delete',
            ),
            110 => 
            array (
                'id' => 181,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'festival',
                'action' => 'isactive',
            ),
            111 => 
            array (
                'id' => 182,
                'module_id' => 28,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'festival',
                'action' => 'export',
            ),
            112 => 
            array (
                'id' => 183,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'caste',
                'action' => 'index',
            ),
            113 => 
            array (
                'id' => 184,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'caste',
                'action' => 'create',
            ),
            114 => 
            array (
                'id' => 185,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'caste',
                'action' => 'update',
            ),
            115 => 
            array (
                'id' => 186,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'caste',
                'action' => 'view',
            ),
            116 => 
            array (
                'id' => 187,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'caste',
                'action' => 'delete',
            ),
            117 => 
            array (
                'id' => 188,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'caste',
                'action' => 'isactive',
            ),
            118 => 
            array (
                'id' => 189,
                'module_id' => 29,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'caste',
                'action' => 'export',
            ),
            119 => 
            array (
                'id' => 190,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'religion',
                'action' => 'index',
            ),
            120 => 
            array (
                'id' => 191,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'religion',
                'action' => 'create',
            ),
            121 => 
            array (
                'id' => 192,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'religion',
                'action' => 'update',
            ),
            122 => 
            array (
                'id' => 193,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'religion',
                'action' => 'view',
            ),
            123 => 
            array (
                'id' => 194,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'religion',
                'action' => 'delete',
            ),
            124 => 
            array (
                'id' => 195,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'religion',
                'action' => 'isactive',
            ),
            125 => 
            array (
                'id' => 196,
                'module_id' => 30,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'religion',
                'action' => 'export',
            ),
            126 => 
            array (
                'id' => 197,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'List',
                'name' => 'list',
                'controller' => 'relation',
                'action' => 'index',
            ),
            127 => 
            array (
                'id' => 198,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'Create',
                'name' => 'create',
                'controller' => 'relation',
                'action' => 'create',
            ),
            128 => 
            array (
                'id' => 199,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'Update',
                'name' => 'update',
                'controller' => 'relation',
                'action' => 'update',
            ),
            129 => 
            array (
                'id' => 200,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'View',
                'name' => 'view',
                'controller' => 'relation',
                'action' => 'view',
            ),
            130 => 
            array (
                'id' => 201,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'Delete',
                'name' => 'delete',
                'controller' => 'relation',
                'action' => 'delete',
            ),
            131 => 
            array (
                'id' => 202,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'Is active',
                'name' => 'isactive',
                'controller' => 'relation',
                'action' => 'isactive',
            ),
            132 => 
            array (
                'id' => 203,
                'module_id' => 31,
                'panel' => 'Backend',
                'title' => 'Export',
                'name' => 'export',
                'controller' => 'relation',
                'action' => 'export',
            ),
        ));
        
        
    }
}