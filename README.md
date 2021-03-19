# Speedtest Tracker

[![Docker pulls](https://img.shields.io/docker/pulls/henrywhitaker3/status-tracker?style=flat-square)](https://hub.docker.com/r/henrywhitaker3/status-tracker) [![GitHub Workflow Status](https://img.shields.io/github/workflow/status/henrywhitaker3/Status-Tracker/Stable?label=master&logo=github&style=flat-square)](https://github.com/henrywhitaker3/Status-Tracker/actions) [![last_commit](https://img.shields.io/github/last-commit/henrywhitaker3/Status-Tracker?style=flat-square)](https://github.com/henrywhitaker3/Status-Tracker/commits) [![issues](https://img.shields.io/github/issues/henrywhitaker3/Status-Tracker?style=flat-square)](https://github.com/henrywhitaker3/Status-Tracker/issues) [![commit_freq](https://img.shields.io/github/commit-activity/m/henrywhitaker3/Status-Tracker?style=flat-square)](https://github.com/henrywhitaker3/Status-Tracker/commits) ![version](https://img.shields.io/badge/version-v1.0.0-success?style=flat-square) [![license](https://img.shields.io/github/license/henrywhitaker3/Status-Tracker?style=flat-square)](https://github.com/henrywhitaker3/Status-Tracker/blob/master/LICENSE)

Track the status of your services and get notified when they go offline. Currently supports running HTTP and ping checks on services, with notifications to Slack and Discord.

![2021-03-18_23-20](https://user-images.githubusercontent.com/36062479/111709997-a310be00-8840-11eb-98f5-8555542bd2f7.png)


## Features

- Automatically run status checks every X seconds
- HTTP and ping checks
- Slack/Discord notifications
- [healthchecks.io](https://healthchecks.io) integration
- Organizr integration

## Installation & Setup

### Using Docker

A docker image is available [here](https://hub.docker.com/r/henrywhitaker3/status-tracker), you can create a new conatiner by running:

```bash
docker create \
      --name=status \
      -p 8766:80 \
      -v /path/to/data:/config \
      --restart unless-stopped \
      henrywhitaker3/status-tracker
```

### Using Docker Compose

```yml
version: '3.3'
services:
    speedtest:
        container_name: status
        image: henrywhitaker3/status-tracker
        ports:
            - 8766:80
        volumes:
            - /path/to/data:/config
        environment:
            - TZ=
            - PGID=
            - PUID=
        restart: unless-stopped
```

#### Images

There are 2 different docker images:

| Tag | Description |
| :----: | --- |
| latest | This is the stable release of the app |
| dev | This release has more features, although could have some bugs |

#### Parameters

Container images are configured using parameters passed at runtime (such as those above). These parameters are separated by a colon and indicate `<external>:<internal>` respectively. For example, `-p 8080:80` would expose port `80` from inside the container to be accessible from the host's IP on port `8080` outside the container.

|     Parameter             |   Function    |
|     :----:                |   --- |
|     `-p 8765:80`          |   Exposes the webserver on port 8765  |
|     `-v /config`          |   All the config files reside here.   |
|     `-e CHECK_INTERVAL`   |   Interval in seconds between queued checks. Defaults to 60 seconds |
|     `-e CHECK_TIMEOUT`    |   Timeout in seconds before a check is marked as failed. Defaults to 10 seconds |
|     `-e PUID`             |   Optional. Supply a local user ID for volume permissions   |
|     `-e PGID`             |   Optional. Supply a local group ID for volume permissions  |

    
### Manual Install

It's not suggested to run this as a manual install, but if oyu know how to run a Laravel/PHP app, then you should be fine.
