<?php

/**
 * News Manager Turkish language file by m[e]s - emresanli.com
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "Haber Yönetimi",

# error messages
"ERROR_ENV"           =>  "Gönderilere erişimde bir sorun var. Lütfen /data, /backups klasörünü ve alt klasörlerini <em>CHMOD 777</em> yaparak tekrar deneyin.",
"ERROR_SAVE"          =>  "<b>Hata:</b> Değişiklikleriniz kaydedilemiyor. Lütfen /data, /backups klasörünü ve alt klasörlerini <em>CHMOD 777</em> yaparak tekrar deneyin.",
"ERROR_DELETE"        =>  "<b>Hata:</b> Haber silinemiyor. Lütfen /data, /backups klasörünü ve alt klasörlerini <em>CHMOD 777</em> yaparak tekrar deneyin.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Değişiklikleriniz kaydedildi.",
"SUCCESS_DELETE"      =>  "Haber başarıyla silindi.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Uyarı:</b> Büyük olasılıkla <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> dosyasını güncellemeniz gerekiyor.",

# admin button (top-right)
"SETTINGS"            =>  "Ayarlar",
"NEW_POST"            =>  "Yeni Haber Yaz",

# admin panel
"POST_TITLE"          =>  "Haber Başlığı",
"DATE"                =>  "Tarih",
"EDIT_POST"           =>  "Haberi Düzenle",
"VIEW_POST"           =>  "Haberi Görüntüle",
"DELETE_POST"         =>  "Haberi Sil",
"POSTS"               =>  "haber",

# edit settings
"NM_SETTINGS"         =>  "Haber Yönetim Ayarları",
"DOCUMENTATION"       =>  "Daha fazla bilgi için <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">News Manager</a> sayfasını ziyaret edin.",
"PAGE_URL"            =>  "Haberleri görüntüleme şablonu",
"LANGUAGE"            =>  "Haber sayfası dili:",
"SHOW_POSTS_AS"       =>  "Haberler şu şekilde görüntülenecek",
"FULL_TEXT"           =>  "Tam Yazı",
"EXCERPT"             =>  "Kısaltılmış",
"PRETTY_URLS"         =>  "Haberler ve arşivler için düzgün URL kullanılsın",
"PRETTY_URLS_NOTE"    =>  "Bunu etkinleştirirseniz, .htaccess dosyasını da güncellemeniz gerekecek.",
"EXCERPT_LENGTH"      =>  "Kısaltma boyutu (karakter)",
"POSTS_PER_PAGE"      =>  "Haber sayfasındaki girdi sayısı",
"RECENT_POSTS"        =>  "Yan paneldeki haber başlığı sayısı",

# edit post
"POST_OPTIONS"        =>  "Seçenekler",
"POST_SLUG"           =>  "Kısa Ad / URL",
"POST_TAGS"           =>  "Etiketler (virgülle ayırın)",
"POST_DATE"           =>  "Yayın tarihi (<i>gün/ay/yıl</i>)",
"POST_TIME"           =>  "Yayın zamanı (<i>saat:dakika</i>)",
"POST_PRIVATE"        =>  "Gizli haber",
"LAST_SAVED"          =>  "Son Kaydedilme Tarihi",

# htaccess
"HTACCESS_HELP"       =>  "Haberler ve arşivler için düzgün URL kullanmak isterseniz, kök dizindeki <code>.htaccess</code> kodlarını aşağıdakilerle değiştirin.",
"GO_BACK_WHEN_DONE"   =>  "Bu sayfayla işiniz bittiğinde, aşağıdaki düğmeye basarak ana panele geri dönebilirsiniz.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Ayarları Kaydet",
"SAVE_POST"           =>  "Haberi Gönder",
"FINISHED"            =>  "Bitirdim",
"CANCEL"              =>  "İptal",
"DELETE"              =>  "Sil",
"OR"                  =>  "veya",

# front-end/site
"FOUND"               =>  "Şu haber bulundu:",
"NOT_FOUND"           =>  "Aramanızla ilgili herhangi bir sonuç bulunamadı.",
"NOT_EXIST"           =>  "Böyle bir haber yok.",
"NO_POSTS"            =>  "Henüz bir haber yayınlanmadı.",
"PUBLISHED"           =>  "Gönderim Tarihi:",
"TAGS"                =>  "Etiketler",
"OLDER_POSTS"         =>  "Eski Haberler",
"NEWER_POSTS"         =>  "Yeni Haberler",
"SEARCH"              =>  "Arama",
"GO_BACK"             =>  "Geri Dön",

# date settings
"DATE_FORMAT"         =>  "%d.%m.%Y"

);

?>
