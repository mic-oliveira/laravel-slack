<?php

return [

    /*
    |---------------------------------------------------------------------------------
    |   SLACK API URL
    |---------------------------------------------------------------------------------
    | URL basica da api do slack
    |
    |
     */
    'slack_api_url' =>  env('SLACK_API_URL', 'https://slack.com/api'),

    /*
    |----------------------------------------------------------------------------------
    |   SLACK TOKEN
    |----------------------------------------------------------------------------------
    |
    |
    |
     */
    'slack_bot_token'   => env('SLACK_BOT_TOKEN'),

    /*
    |----------------------------------------------------------------------------------
    |   POST MESSAGE
    |----------------------------------------------------------------------------------
    |
    |
    |
     */
    'slack_post_message_url' => env('SLACK_BOT_MESSAGE', 'https://slack.com/api/chat.postMessage'),

    /*
    |----------------------------------------------------------------------------------
    |   DEFAULT CHANNEL
    |----------------------------------------------------------------------------------
    | Canal padrao para envio de mensagens
    |
    |
     */
    'slack_channels' =>  ['#general'],

    /*
    |----------------------------------------------------------------------------------
    |   BASE CHANNELS URL
    |----------------------------------------------------------------------------------
    | URL padrão para a lista de canais do slack
    |
    |
     */
    'slack_channels_url' => env('SLACK_BOT_CHANNELS_API_URL', 'https://slack.com/api/conversations.list'),

    /*
    |----------------------------------------------------------------------------------
    |   BASE GROUPS/PRIVATE CHANNELS URL
    |----------------------------------------------------------------------------------
    | URL padrão para a lista de canais privados do slack
    |
    |
     */
    'slack_groups_url' => env('SLACK_BOT_GROUPS_API_URL', 'https://slack.com/api/conversations.list'),

    /*
    |----------------------------------------------------------------------------------
    |   BASE USERS URL
    |----------------------------------------------------------------------------------
    |
    |
    |
     */
    'slack_users_url' => env('SLACK_BOT_USER_LIST_API_URL', 'https://slack.com/api/conversations.list'),

    /*
    |----------------------------------------------------------------------------------
    |   APP NAME
    |----------------------------------------------------------------------------------
    | Nome padrao do aplicativo
    |
    |
     */
    'app_name'  =>  null,

    /*
    |----------------------------------------------------------------------------------
    |   DEFAULT APP IMAGE
    |----------------------------------------------------------------------------------
    | Imagem padrao do app
    |
    |
     */
    'app_image' =>  'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS_0Qk6g7HfyFsks5MDkJFKw7EYO3nrY0JvEH318XbXdzJuqiEi',
];
