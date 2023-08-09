## How to set up this program
Add a .env.local with your dabase url as seen in .env, `DATABASE_URL=...`, or change the one in .env if you don't upload it to git. Make sure to create your own new database schema to be linked to.  
Run `composer install` and `npm install`, then `npm run build` to get bootstrap with encore.  
Run `php bin/console doctrine:migrations:migrate` to migrate the tables.  
Run `symfony server:start` to run the dev server, or use an alternative like xampp/nginx to run it.  
  
Congrats! If everything is correct the app should be running now.  
The public github repository of this zipfile can be found here: https://github.com/Mitchel0058/microblog.  
  
First you need to login to do anything, go to the login button and to then the register button since you don't have an account yet. From there on you can add/edit/delete posts and show them fully by clicking on them.  
The one thing I didn't get to do was send an email when a blog message gets send, I was trying it on a differnt branch but didn't quite get it to work and due to the time restraints with the internship being soon I'd rather show everything I did get to work fully. Most of the time was spent on learning how everything works in symfony. I already knew a lot of parts, but they just worked slightly differently in symfony, which made me have to find ways to do it with symfony.
