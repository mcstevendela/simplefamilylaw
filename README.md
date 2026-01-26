<div id="top"></div>

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/rotatedigital/builder_v2">
    <img src="src/images/logo.png" alt="Logo" width="80" height="auto">
  </a>

<h3 align="center">THEME BUILDER v.2.0.1</h3>
<hr>
  <p align="center">
   Based on the new Wordpress Gutenberg editor -  Builder will help you build faster websites and manage them more easily.
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project 🔥

<div align="center">
  <a href="https://github.com/rotatedigital/builder_v2">
    <img src="src/screenshot.png" alt="Logo" width="300" height="auto">
  </a>
  </div>
This is a system a lot of us been waiting for. It's time to end era of Elementor and Divi website with new, fresh and fast way of building online services.❗ Are you ready to jump into new generation of websites?!
🔥  Let's ge this party started! 🔥

<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

* [Wordpress CMS](https://wordpress.org/)
* [Timber](https://timber.github.io/docs/)
* [Advanced Custom Fields](https://www.advancedcustomfields.com/)
* [Tailwind](https://tailwindcss.com/)
* [Gulp.js](https://gulpjs.com/)
* [Visual Studio Code](https://code.visualstudio.com/)
* [JQuery](https://jquery.com)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To start clone/download repository to your local drive.

### Prerequisites

Before using make sure you have node, npm and npx installed.

```sh
 node --version
 npm --version
 npx --version

```

After installing npm check if you have gulp installed by running
  ```sh
  gulp -v
  ```

  If you don't have gulp installed you can use bottom commends to install gulp command line and gulp

  ```sh
  npm i gulp-cli
  npm i gulp
  ```

### Installation

1. Log in to your Github Account
2. Clone the repo
   ```sh
   git clone https://github.com/rotatedigital/builder_v2.git
   ```
3. Open terminal on main folder and install packages
   ```sh
   npm install
   ```
   __If any error acours please delete package-lock.json and node_modules folder and try previous command again.__ 
4. After installing you can start using build with base command 
   ```sh
   npm run dev
   ```

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

With this build **_watchForChanges_** will be your main command. After busy day of coding you can prepare dist folder for production by using command

  ```sh
    npm run build
   ```



<!-- ROADMAP -->
## Roadmap

- [ ] In SRC folder you can find every base file and you ALWAYS makes any theme changes in that folder
- [ ] For global **Tailwind** changes you can use **tailwind.config.js**

> :warning: After making any changes you have to save any scss file to reload the actual changes. :warning:


- [ ] Most changes in **PHP** are made in **functions.php** and **blocks.php**
- [ ] For any visual structure of the project you can go to **templates** folder
    - [ ] Fonts and link are loaded in **html-header.twig**
    - [ ] Body of the page is in  **base.twig** with footer and header
- [ ] Any styles you can modify in **scss** folder
- [ ] All build javascript code is located in **js/bundle.js** file.
- [ ] Fonts and link are loaded in **html-header.twig**


<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[issues-url]: https://github.com/rotatedigital/custom-movers-theme/issues
[logo]: src/images/logo.png
[build-screenshot]: src/screenshot.png