# resourcepack-upload
Simple plain php/js resourcepack upload solution for linux apache servers. Maybe it's simple but it helps me a lot on my own server by keeping all resourcepacks in the same filesystem and genreating md5 checksum for the uploaded new one. By specifing additional GET `timestamp` parameter in your URL you can easly fetch historic version of requested resourcepack. Additionally you can hook an external oauth support (not included) to redirect unpleasant guests into forbidden page.

## Examples
Dark Upload Page<br>
<img src="https://i.imgur.com/eRd4n7E.png" alt="Dark Upload Page" height="200"><br>
Light Upload Page<br>
<img src="https://i.imgur.com/JK7EIwo.png" alt="Light Upload Page" height="200"><br>
Dark Result Page<br>
<img src="https://i.imgur.com/PRLHlKM.png" alt="Dark Result Page" height="200"><br>
Dark Forbidden Access Page<br>
<img src="https://i.imgur.com/LIyWDnU.png" alt="Dark Forbidden Access Page" height="200"><br>

## Setup
Just put all files in your webserver directory and change options in **inc/config.php**

## Language
By default supports only two languages: **english** and **polish**. You can add more by putting them into **inc/lang** folder.
