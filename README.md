# Branch Theme

This is the repo containing the WordPress theme for the Branch magazine site.

Branch is an online magazine written by and for people who dream of a sustainable and just internet for all. It is edited and funded by [Green Web Foundation](https://greenweb.org) on behalf of the volunteer-run [Climate Action.tech](https://climateaction.tech) community.

## Developing with npm

### Prerequisites

- Node.js and npm
- WordPress install running locally
- Git repo initialised in theme folder - https://github.com/climateaction-tech/branch-theme


### Installing Dependencies

- Open terminal and navigate to theme folder with git repo already installed.
- Run: `$ npm install`
- If necessary set-up `.gitignore` folder to ignore node_modules folder, contents might be

```
#ignore the gulp folder
node_modules/*
```

### Running
To work with and compile Sass files on the fly:

- `$ npm run watch`

Or, to run with Browser-Sync:

- First change the browser-sync options to reflect your environment in the file `src/build/browser-sync.config.json` in the beginning of the file:
```javascript
{
  module.exports = {
      "proxy": "https://branch.local", // Change here
    ...
};
```
- then run: `$ npm run watch-bs`
