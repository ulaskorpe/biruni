<?php

namespace App\Console\Commands;

use App\Models\PermissionGroup;
use Illuminate\Console\Command;
use App\Models\SpatiePermission;

class CreateDefaultPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-default-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Varsayılan permission listesini oluşturuyoruz.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $permission_groups = [
            [
                'name' => 'Rol',
                'model' => 'Role'
            ],
            [
                'name' => 'Kullanıcı',
                'model' => 'User'
            ],
            [
                'name' => 'Medya Kütüphanesi',
                'model' => 'Media'
            ],
            [
                'name' => 'Üye',
                'model' => 'User'
            ],
            [
                'name' => 'Duyuru',
                'model' => 'Announcement'
            ],
            [
                'name' => 'Slider',
                'model' => 'Slider'
            ],
            [
                'name' => 'Menü',
                'model' => 'Menu'
            ],
            [
                'name' => 'Form',
                'model' => 'Form'
            ],
            [
                'name' => 'İçerik Şablonu',
                'model' => 'DesignTemplate'
            ],
            [
                'name' => 'Etiket',
                'model' => 'Tag'
            ],
            [
                'name' => 'İçerik Tipi',
                'model' => 'ContentType'
            ],
            [
                'name' => 'İçerik Tipi Seçenek',
                'model' => 'ContentAttribute'
            ],
            [
                'name' => 'İçerik Sidebar',
                'model' => 'Sidebar'
            ],
            [
                'name' => 'İçerik Layout',
                'model' => 'Layout'
            ],
            [
                'name' => 'Header Layout',
                'model' => 'HeaderLayout'
            ],
            [
                'name' => 'İçerik Kart',
                'model' => 'CardLayout'
            ],
            [
                'name' => 'Site Ayarları',
                'model' => 'GlobalSettings'
            ],
            [
                'name' => 'E-Posta Şablon',
                'model' => 'EmailContent'
            ],
            [
                'name' => 'URL',
                'model' => 'Link'
            ],
            [
                'name' => 'Yönlendirme',
                'model' => 'RedirectUri'
            ],
            [
                'name' => 'Reklam Alanı',
                'model' => 'CommercialAdArea'
            ],
            [
                'name' => 'Reklam',
                'model' => 'CommercialAd'
            ]
        ];

        foreach ($permission_groups as $key => $group) {
            
            $exsists = PermissionGroup::where('model',$group['model'])->first();

            if( ! $exsists ){
                $permission_group = PermissionGroup::create([
                    'name' => $group['name'].' Yönetimi',
                    'model' => $group['model']
                ]);
    
                $permissionEk = $group['name'] == 'Üye' ? 'customer' : $group['model'];
    
                $view = SpatiePermission::create([
                    'name' => 'view-'.$permissionEk,
                    'view_name' => 'Görüntüle',
                    'permission_group_id' => $permission_group->id
                ]);
    
                $create = SpatiePermission::create([
                    'name' => 'create-'.$permissionEk,
                    'view_name' => 'Yeni Ekle',
                    'permission_group_id' => $permission_group->id
                ]);
    
                $edit = SpatiePermission::create([
                    'name' => 'edit-'.$permissionEk,
                    'view_name' => 'Düzenle',
                    'permission_group_id' => $permission_group->id
                ]);
    
                $delete = SpatiePermission::create([
                    'name' => 'delete-'.$permissionEk,
                    'view_name' => 'Sil',
                    'permission_group_id' => $permission_group->id
                ]);

            }

        }

    }
}