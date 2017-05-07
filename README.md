Proximate/App
===

Introduction
---

This project contains a web app that connects to a Proximate API instance to control a Proximate
HTTP recording proxy. It has the following features:

* List the pages in the cache
* Delete pages in the cache
* Test the proxy
* Add a new crawl to the queue, using Proximate/Crawler
* View the proxy logs

Usage
---

Users who wish to try the system, or would like to run everything without modification, can
use the Docker Compose config in this folder:

    docker-compose up

The configuration currently specifies a London timezone, and makes time and timezone
data from the host available to the guest as read-only volumes. That means that the solution
is dependent on a Linux host for now, but this can be changed in the future if there is
demand.

If you wish to set up the components separately, you can run the app separately using Docker's
`run` command, contained within this script:

    ./host-start.sh
