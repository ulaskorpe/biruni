<?php

use Carbon\Carbon;
use App\Models\Link;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContentPreview;
use App\Models\ContentCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

if (!function_exists('checkIsMobile')) {

    function checkIsMobile(Request $request)
    {
        $isMobile = false;

        $useragent = $request->userAgent();

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            $isMobile = true;
        }

        return $isMobile;
    }
}

if (!function_exists('sortArrayByParentId')) {

    function sortArrayByParentId($array, $parentId = null, $depth = 0)
    {
        $result = [];

        foreach ($array as $item) {

            if ($item['parent_id'] === $parentId) {
                $item['depth'] = $depth;
                $item['depth_name'] = $depth > 0 ? str_repeat('↦ ', $depth) . $item['name'] : $item['name'];
                $result[] = $item;

                $children = sortArrayByParentId($array, $item['id'], $depth + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }
}

if (!function_exists('formatOptionType')) {

    function formatOptionType($value, $option_type)
    {

        switch ($option_type) {

            case 'date':
                return Carbon::parse($value)->format('d-m-Y');
                break;

            case 'datetime':
                return Carbon::parse($value)->format('d-m-Y H:i');
                break;

            case 'time':
                return Carbon::parse($value)->format('H:i');
                break;

            default:
                return $value;
                break;
        }
    }
}

if (!function_exists('formatOptionTypeToVueMask')) {

    function formatOptionTypeToVueMask($value, $option_type)
    {

        switch ($option_type) {

            case 'date':
                return Carbon::parse($value)->format('d.m.Y');
                break;

            case 'time':
                return Carbon::parse($value)->format('H:i');
                break;

            default:
                return $value;
                break;
        }
    }
}

if (!function_exists('getImageWithHeight')) {

    function getImageWithHeight($file_uri) {

        $imageSizes = [];

        if (!$file_uri || empty($file_uri)) {
            return $imageSizes;
        }

        $check_file = Http::get($file_uri);

        if ($check_file->status() === 404) {
            return [];
        }

        $file_ext = pathinfo($file_uri, PATHINFO_EXTENSION);

        if ($file_ext === 'svg') {

            $svg_content = file_get_contents($file_uri);
            $xml = simplexml_load_string($svg_content);
            $attributes = $xml->attributes();
            $width = (string) $attributes->width;
            $height = (string) $attributes->height;

            if (empty($width) || empty($height)) {
                if (isset($attributes->viewBox)) {
                    $viewBox = explode(' ', (string) $attributes->viewBox);
                    $width = $viewBox[2];
                    $height = $viewBox[3];
                }
            }

            $imageSizes = [$width, $height];
        } else if (in_array($file_ext, ['JPEG', 'JPG', 'jpeg', 'jpg', 'PNG', 'png', 'GIF', 'gif', 'webp', 'WEBP'])) {

            list($width, $height) = getimagesize($file_uri);

            $imageSizes = [$width, $height];
        }

        return $imageSizes;
    }
}


if (!function_exists('randomColor')) {

    function randomColor()
    {
        return '#' . substr(md5(rand()), 0, 6);
    }
}


if (!function_exists('generateStar')) {

    function generateStar(int $count)
    {

        $html = '';

        for ($i = 0; $i < $count; $i++) {
            $html .= '<svg width="15" height="15" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="#FFC107" d="M12 0l3.6 7.3 8.1 1.2-5.9 5.7 1.4 8.1L12 18.8 4.8 22.3 6.2 14.2 0.3 8.5l8.1-1.2z"/></svg>';
        }

        return $html;
    }
}

if (!function_exists('generateUri')) {

    function generateUri($content, $link, $update = false, $categoryForUri = null)
    {

        $base_url = $content->slug_org ? $content->slug_org : $content->slug;
        $path = $base_url;
        $model = class_basename($content);

        if ($content->parent) {

            $path = $content->parent->uri->link . '/' . $base_url;
        } else {

            if ($model == 'Content') {

                if (!$content->content_type->has_url) return;

                if ($content->content_type->use_taxonomy_link && $content->content_type->taxonomy) {
                    $path = $content->content_type->taxonomy->name . '/' . $base_url;
                }

                //kategorisi varsa en alttaki kategorinin url bilgisini eklemeliyiz.
                if (!$content->content_type->use_taxonomy_link && $categoryForUri) {
                    $categoryDetails = ContentCategory::with('uri')->select('id', 'name')->where('id', $categoryForUri)->first();
                    if ($categoryDetails && $categoryDetails->uri) {
                        $path = $categoryDetails->uri->link . '/' . $base_url;
                    }
                }
            }


            if ($model == 'Tag') {
                $path = 'tag/' . $base_url;
            }
        }

        $counter = 1;

        $uri_lang = $content->language == config('languages.default') || !$content->language ? '' : $content->language . '/';
        $final_uri = config('app-ea.app_url') . '/' . $uri_lang . $path;

        if (!$update) {
            while (!Link::isUnique($final_uri, $content->language)) {
                $final_uri = $final_uri . '-' . $counter;
                $counter++;
            }
        }

        $link->link = $path;
        $link->language = $content->language ?? config('languages.default');
        $link->final_uri = $final_uri;

        $content->uri()->save($link);
    }
}

if (!function_exists('saveBreadCrumb')) {

    function saveBreadCrumb($content)
    {

        $model = class_basename($content);
        $breadcrumb = [];

        if ($content->parent) {

            $breadcrumb = $content->parent->uri->breadcrumb;
            $breadcrumb[] = [
                "title" => $content->parent->name,
                "url"  => $content->parent->uri->final_uri,
            ];
        } else {

            if ($model == 'Content') {

                if (!$content->content_type->has_url) return;

                $breadcrumb = [];

                if ($content->content_type->has_category) {

                    $last_category = $content->content_categories->last();
                    if ($last_category) {
                        $breadcrumb = $last_category->uri->breadcrumb;
                        $breadcrumb[] = [
                            'title' => $last_category->name,
                            'url' => $last_category->uri->final_uri
                        ];
                    }
                }

                foreach ($content->getBreadCrumb() as $bread) {
                    $breadcrumb[] = $bread;
                }
            }
        }

        $content->uri->update([
            'breadcrumb' => $breadcrumb
        ]);
    }
}


if (!function_exists('getBaseAndAnimClasses')) {

    function getBaseAndAnimClasses($data)
    {

        $classes = [];

        if ($data['baseDesignOptions']['class']) $classes[] = $data['baseDesignOptions']['class'];
        if (isset($data['baseDesignOptions']['position'])) $classes[] = $data['baseDesignOptions']['position'];

        foreach ($data['baseDesignOptions']['margin'] as $key => $value) {
            if ($value) $classes[] = $value;
        }
        foreach ($data['baseDesignOptions']['padding'] as $key => $value) {
            if ($value) $classes[] = $value;
        }

        if ($data['animOptions']['use']) {

            if ($data['animOptions']['class']) {

                $classes[] = 'animate__animated';
                $classes[] = 'anim-opacity-0';
                $classes[] = $data['animOptions']['class'];
            }

            if ($data['animOptions']['delay']) {
                $classes[] = $data['animOptions']['delay'];
            }
        }

        return $classes;
    }
}


if (!function_exists('searchInArray')) {

    function searchInArray($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {

            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, searchInArray($subarray, $key, $value));
            }
        }

        return $results;
    }
}



if (!function_exists('generateElementHtml')) {

    function generateElementHtml($html, Content|ContentCategory|ContentPreview|null $content)
    {

        //once bos paragraflari kaldiralim.
        $html = Str::replace('<p><br></p>', '', $html);

        //simdi dinamik bilgiler varsa onlari guncelleyelim.
        /*
        $pattern = '/---(.*?)---/';
        preg_match_all($pattern, $html, $matches);

        dd($matches[1]);
        */


        return $html;
    }
}

if (!function_exists('languageName')) {

    function languageName($lang)
    {

        switch ($lang) {

            case 'tr':
                return 'Türkçe';
                break;

            case 'en':
                return 'English';
                break;

            case 'ru':
                return 'Русский';
                break;

            default:
                return 'Default';
                break;
        }
    }
}

if (!function_exists('formatNumberToCurrency')) {

    function formatNumberToCurrency($number)
    {
        $decimalPart = explode('.', $number)[1] ?? '';

        // Eğer virgül sonrası kısım boşsa veya sıfırsa, virgülü kaldır
        if (empty($decimalPart) || $decimalPart == '00') {
            $formattedNumber = number_format($number, 0, ',', '.');
        } else {
            $formattedNumber = $number;
        }

        return $formattedNumber;
    }
}


if (!function_exists('checkPermission')) {

    function checkPermission($permission)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user->hasPermissionTo($permission) || $user->hasRole('super-admin');
    }
}

if (!function_exists('firstWordBold')) {

    function firstWordBold($sentence)
    {
        $words = explode(' ', $sentence, 2);

        return '<b>' . $words[0] . '</b>' . (isset($words[1]) ? ' ' . $words[1] : '');
    }
}

if (!function_exists('getMonthList')) {

    function getMonthList()
    {

        return [
            [
                'label' => 'Ocak',
                'value' => '01'
            ],
            [
                'label' => 'Şubat',
                'value' => '02'
            ],
            [
                'label' => 'Mart',
                'value' => '03'
            ],
            [
                'label' => 'Nisan',
                'value' => '04'
            ],
            [
                'label' => 'Mayıs',
                'value' => '05'
            ],
            [
                'label' => 'Haziran',
                'value' => '06'
            ],
            [
                'label' => 'Temmuz',
                'value' => '07'
            ],
            [
                'label' => 'Ağustos',
                'value' => '08'
            ],
            [
                'label' => 'Eylül',
                'value' => '09'
            ],
            [
                'label' => 'Ekim',
                'value' => '10'
            ],
            [
                'label' => 'Kasım',
                'value' => '11'
            ],
            [
                'label' => 'Aralık',
                'value' => '12'
            ]
        ];
    }
}

if (!function_exists('mime2ext')) {
    function mime2ext($mime)
    {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'audio/mp4'                                                                 => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'font/otf'                                                                  => 'otf',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'font/ttf'                                                                  => 'ttf',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'image/webp'                                                                => 'webp',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'font/woff'                                                                 => 'woff',
            'font/woff2'                                                                => 'woff2',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
    }
}
