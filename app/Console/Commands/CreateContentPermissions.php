<?php

namespace App\Console\Commands;

use App\Models\ContentType;
use App\Models\PermissionGroup;
use Illuminate\Console\Command;
use App\Models\SpatiePermission;

class CreateContentPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-content-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'İçerik tiplerine göre yetkilendirme.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $content_types = ContentType::withoutGlobalScopes()->select('id','name','uuid','language')->where('language',config('languages.default'))->whereNull('deleted_at')->get();


        foreach ($content_types as $key => $group) {
            
            $permission_group = PermissionGroup::updateOrCreate([
                'name' => $group->name.' Yönetimi',
                'model' => 'Content'
            ],[
                'name' => $group->name.' Yönetimi',
                'model' => 'Content'
            ]);

            $permissionEk = $group->uuid;

            $view = SpatiePermission::updateOrCreate([
                'name' => 'view-'.$permissionEk,
                'view_name' => 'Görüntüle',
                'permission_group_id' => $permission_group->id
            ],[
                'name' => 'view-'.$permissionEk,
                'view_name' => 'Görüntüle',
                'permission_group_id' => $permission_group->id
            ]);

            $create = SpatiePermission::updateOrCreate([
                'name' => 'create-'.$permissionEk,
                'view_name' => 'Yeni Ekle',
                'permission_group_id' => $permission_group->id
            ],[
                'name' => 'create-'.$permissionEk,
                'view_name' => 'Yeni Ekle',
                'permission_group_id' => $permission_group->id
            ]);

            $edit = SpatiePermission::updateOrCreate([
                'name' => 'edit-'.$permissionEk,
                'view_name' => 'Düzenle',
                'permission_group_id' => $permission_group->id
            ],[
                'name' => 'edit-'.$permissionEk,
                'view_name' => 'Düzenle',
                'permission_group_id' => $permission_group->id
            ]);

            $delete = SpatiePermission::updateOrCreate([
                'name' => 'delete-'.$permissionEk,
                'view_name' => 'Sil',
                'permission_group_id' => $permission_group->id
            ],[
                'name' => 'delete-'.$permissionEk,
                'view_name' => 'Sil',
                'permission_group_id' => $permission_group->id
            ]);

        }

    }
}