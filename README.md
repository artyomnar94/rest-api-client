# YII2-Core-api-client
Wrapper on WP Core Api

[![Latest Stable Version](https://poser.pugx.org/artyomnar/yii2-core-api-client/v/stable.png)](https://packagist.org/packages/artyomnar/yii2-core-api-client)
[![Total Downloads](https://poser.pugx.org/artyomnar/yii2-core-api-client/downloads.png)](https://packagist.org/packages/artyomnar/yii2-core-api-client)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require artyomnar/yii2-core-api-client
```

or add

```
"artyomnar/yii2-core-api-client": "*"
```

to the require section of your composer.json.

Settings
------------

- Set in yii-app as component:
```  
  'coreApiClient' => [
    'class' => 'artyomnar\CoreApiClient\CoreApi',
    'coreHost' => YII_ENV_PROD? 'https://api-app.com/v1/' : 'https://test.api-app.com/v1/'    
  ],
```
Usage
------------

```
$loginForm = new LoginForm();
if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate()) {
    $userData = Yii::$app->coreApiClient->user->auth($loginForm);
    $userEntity = new User($userData);
}
```
