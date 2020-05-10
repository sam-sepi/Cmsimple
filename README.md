# CMSimple

Trivial CMS in PHP and JS

## Get started

```
git clone https://github.com/sam-sepi/Cmsimple
```

## Documentation

CMSimple does not use databases. Any content shared between server and client is a JSON object. 

To add or update the contents you must authenticate by sending the user and pass data in JSON format to the jwt.php file (located in the api folder). After checking the correspondence with the data in the .env file, a JWT is released and saved in local storage.

Then you can send data (id, title, description, text) via POST in JSON format to save the content on the server. The ID parameter will also be the name of the .txt file saved online and has a maximum of 20 characters. Same ID changes the contents of the file.

In the text parameter html code can be filtered.

Examples of how to manage the client side are the auth.html, post.html, update.html files. Personally I recommend keeping these files locally and pointing with js fetch to the server (if the cms was online).

## Author

Sam Sepi - Init. work

## License

MIT