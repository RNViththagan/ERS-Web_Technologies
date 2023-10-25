# ERS-Web_Technologies

Then run the apache server and mysql. And then create a database called `ers_fos_db` and import the `ers_fos_db.sql` file.
then go to the `http://localhost/ERS-Web_Technologies/` to access the ERS website</br></br>

Once you clone this repository you need to install the comsoper software. <a href="https://getcomposer.org/download/">Click here to download</a>
</br></br>

if you dont download `vendor` folder, then folow the bellow step. otherwise skip this step and do the next one:</br>
Then open the project file in composer teminal. (open the composer terminal and then `cd C:/xampp/htdocs/ERS-Web_Technologies` and then enter).</br>
then type `composer install` to install the neccesary libraries and packages. </br>

Then enable these extensions in your `php.ini` file (`C:\xampp\php`).</br>

<ol><li>extension=gd</li><li>extension=fileinfo</li><li>extension=zip</li></ol></br>

To enable this, you have to do the following:</br>

<ol>
<li>located the file `c:/xampp/php/php`</li>
<li>open the file</li>
<li>search for `extension=fileinfo` and `extension=gd` and `extension=zip`</li>
<li>if your see `;extension=fileinfo`, `;extension=gd`, `;extension=zip`. Remove the semicolon so it will be like this: `extension=fileinfo`, `extension=gd`, `extension=zip`</li>
<li>if you don't find any result then simply write `extension=fileinfo` `extension=gd` `extension=zip` among the `extensions`</li>
<li>Close the file and run the restart the apache server again</li>
</ol>
