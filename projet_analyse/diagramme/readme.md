This project is the sixth of the training that I am currently doing.
To install it, nothing could be simpler, just open a command terminal in the folder where you want to install the project and run the following command: "git clone https://github.com/hacene92230/p6- SnowTricks.git".
Before executing the command make sure that git is installed. Once the project has been cloned, you can go to the newly downloaded folder via "cd / the project". Replace "the project" with the folder that was cloned.
Then you will have to execute the command "composer install", "composer update" to install and update all the dependencies necessary for the proper functioning of the project.
Now the project should be functional, don't forget to install the database by doing a "php console doctrine:database:create" in the "bin" folder.
Then do a "doctrine:schema:update --force".
If you want to see the different stages of the project, you can go to: https://github.com/hacene92230/p6-SnowTricks/issues/