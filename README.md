# repo-backend
Backend code for the starc repository. It provides API for communicating with search module.

The repository is based on Codeigniter, php framework for developing MVC web applications. 

https://ellislab.com/codeigniter

In this repo I added only some files which are added to the default framework folder structure. I am using Codeigniter version 2.1.0. Basically when the folder structure is set up,  you would just need to add the files from this repo to the respective folders. 

Api controller is responsible for accepting API calls from the search app, and for processing these calls. Based on the call it calls appropriate model which runs some further processing and prepares the response which is then sent back to the app. 

 
