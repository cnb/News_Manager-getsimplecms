<?php

/**
 * News Manager Greek language file by Kyriakos Tetepoulidis
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "News Manager",

# error messages
"ERROR_ENV"           =>  "Υπήρξε ένα σφάλμα στην προσπέλαση του φακέλου των άρθων (/posts) και/ή στο config file. Ορίστε δικαιώματα <em>CHMOD 777</em> στον φάκελο /data, /backups και τους υποφακέλους του και ξαναπροσπαθήστε.",
"ERROR_SAVE"          =>  "<b>Σφάλμα:</b> Δεν ήταν δυνατή η αποθήκευση του άρθρου. Ορίστε δικαιώματα <em>CHMOD 777</em> στον φάκελο /data, /backups και τους υποφακέλους του και ξαναπροσπαθήστε.",
"ERROR_DELETE"        =>  "<b>Σφάλμα:</b> Δεν ήταν δυνατή η διαγραφή του άρθρου. Ορίστε δικαιώματα <em>CHMOD 777</em> στον φάκελο /data, /backups και τους υποφακέλους του και ξαναπροσπαθήστε.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the post. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Οι αλλαγές έχουν αποθηκευτεί.",
"SUCCESS_DELETE"      =>  "Το άρθρο έχει διαγραφεί.",
"SUCCESS_RESTORE"     =>  "The post has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Σημείωση:</b> Πιθανόν πρέπει να ανανεώσετε το αρχείο <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> !",

# admin button (top-right)
"SETTINGS"            =>  "Ρυθμίσεις",
"NEW_POST"            =>  "Δημιουργία Νέου Άρθρου",

# admin panel
"POST_TITLE"          =>  "Τίτλος Άρθρου",
"DATE"                =>  "Ημερομηνία",
"EDIT_POST"           =>  "Επεξεργασία Άρθρου",
"VIEW_POST"           =>  "Εμφάνιση Άρθρου",
"DELETE_POST"         =>  "Διαγραφή Άρθρου",
"POSTS"               =>  "Άρθρο (α)",

# edit settings
"NM_SETTINGS"         =>  "Ρυθμίσεις του News Manager",
"DOCUMENTATION"       =>  "Για περισότερες πληροφορίες των ρυθμίσεων, επισκευθείτε τη <a href=\"http://rxgr.nl/newsmanager/\" target=\"_blank\">σελίδα documentation</a>.",
"PAGE_URL"            =>  "Σελίδα που θα εμφανίζονται τα Άρθρα",
"LANGUAGE"            =>  "Language used on News Page",
"SHOW_POSTS_AS"       =>  "Τα Άρθρα στη σελίδα Άρθρων εμφανίζονται ως",
"FULL_TEXT"           =>  "Πλήρες Κείμενο",
"EXCERPT"             =>  "Περίληψη",
"PRETTY_URLS"         =>  "Χρησιμοποιείστε τα Fancy URLs για τα Άρθρα, Archives, κλπ.",
"PRETTY_URLS_NOTE"    =>  "Αν ενεργοποιήσετε τα Fancy URLs enabled, πρέπει να ενημερώσετε το αρχείο .htaccess μετά την αποθήκευση αυτών των ρυμίσεων.",
"EXCERPT_LENGTH"      =>  "Μήκος περίληψης (σε χαρακτήρες)",
"POSTS_PER_PAGE"      =>  "Αριθμός άρθρων που θα εμφανίζονται στη σελίδα Άρθρα",
"RECENT_POSTS"        =>  "Αριθμός των Νεώτερων Άρθρων (στη Sidebar)",

# edit post
"POST_OPTIONS"        =>  "Επιλογές Άρθρου",
"POST_SLUG"           =>  "Slug/URL",
"POST_TAGS"           =>  "Tags (χωρίστε τα tags με κόμμα)",
"POST_DATE"           =>  "Publish date (<i>mm/dd/yyyy</i>)",
"POST_TIME"           =>  "Publish time (<i>hh:mm</i>)",
"POST_PRIVATE"        =>  "Το Άρθρο είναι Ιδιωτικό (κρυφό)",
"LAST_SAVED"          =>  "Τελευτία Αποθήκευση",

# htaccess
"HTACCESS_HELP"       =>  "Για να ερνεργοποιήσετε τα Fancy URLs για τα Άρθρα, Αrchives, κλπ., αντικαταστήστε τα περιεχόμενα του αρχείου <code>.htaccess</code> με τις γραμμές παρκάτω.",
"GO_BACK_WHEN_DONE"   =>  "Όταν τελειώσετε με αυτή τη σελίδα, πατήστε το κουμπί παρακάτων για να πάτε στο main panel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Αποθήκευση Ρυθμίσεων",
"SAVE_POST"           =>  "Αποθήκευση Άρθρου",
"FINISHED"            =>  "Τελείωσε",
"CANCEL"              =>  "Ακύρωση",
"DELETE"              =>  "Διαγραφή",
"OR"                  =>  "ή",

# front-end/site
"FOUND"               =>  "Το παρακάτω Άρθρο δεν μπορεί να βρεθεί:",
"NOT_FOUND"           =>  "Με συγχωρείτε, η αναζήτησή σας δεν είχε αποτέλεσμα.",
"NOT_EXIST"           =>  "Το ζητούμενο άρθρο δεν υπάρχει.",
"NO_POSTS"            =>  "Δεν έχουν δημοσιευτίε άρθρα ακόμη.",
"PUBLISHED"           =>  "Δημοσιεύτηκε την ",
"TAGS"                =>  "Tags",
"OLDER_POSTS"         =>  "Παλαιότερα Άρθρα",
"NEWER_POSTS"         =>  "Νεώτερα Άρθρα",
"SEARCH"              =>  "Αναζήτηση",
"GO_BACK"             =>  "Πίσω στην προηγούμενη σελίδα",

# date settings
"DATE_FORMAT"         =>  "%e %b %Y"

);

?>
