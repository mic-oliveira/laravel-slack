<p align="center">
  <img width="400" src="https://raw.githubusercontent.com/JonatanLima/logos-arts/master/imgs/laravel_slack.png" />
</p>
# Laravel Slack



Slack integration for Laravel

### Installing

A step by step series of examples that tell you how to get a development env running

Say what the step will be

```
composer require michaelferreira/slack-message
```

To use just call the facade Slack.

Channel
```
Slack::to('#general')->send('message');
```
User
```
Slack::to('@user')->send('message');
```

## Authors

* **Michael de Oliveira Ferreira**  - [michael891989](https://github.com/michael891989/)
* **Aron Peyroteo Cardoso**         - [aronpc](https://github.com/aronpc)
* **Jonatan dos Santos Lima**       - [JonatanLima](https://github.com/JonatanLima)

<!--See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.-->

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


