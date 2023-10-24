# ERS-Web_Technologies

Once you clone this repository you need to install the comsoper software. <a href="https://getcomposer.org/download/">Click here to download</a>
</br>
if you dont download `vendor` folder, then folow the bellow step. otherwise skip this step and do the next one:
Then open the project file in composer teminal. (open the composer terminal and then `cd C:/xampp/htdocs/ERS-Web_Technologies` and then enter).</br>
then type `composer install` to install the neccesary libraries and packages. </br>

If there is any error while doing any of these steps make sure you enable <ol><li>extension=gd</li><li>extension=fileinfo</li><li>extension=zip</li></ol> in your php.ini file. (`C:\xampp\php`)

Then run the apache server and mysql. And then create a database called `ers_fos_db` and import the `ers_fos_db.sql` file.
then go to the `http://localhost/ERS-Web_Technologies/` to access the ERS website
