# BIO SMART PARKING - CLIENT PARKING GATE DISPENSER


## INSTALLATION OS RASPBERRY OS 
Raspberry Pi OS (Legacy) [Download Disini](https://downloads.raspberrypi.com/raspios_oldstable_armhf/images/raspios_oldstable_armhf-2023-12-06/2023-12-05-raspios-bullseye-armhf.img.xz?_gl=1*lsl41n*_ga*MTYwNTczNjQyMC4xNzAyOTU1NDg4*_ga_22FD70LWDS*MTcwMzY5OTA1NS4zLjEuMTcwMzY5OTA3Mi4wLjAuMA..) 

##	Introduction 

Project ini untuk memudahkan cara instalasi client dispenser

##	Supported platforms

* BIO Smart Parking

##	Changelog
2023-12-28 BSP V2.2.0

* Initial version create
* Add installation
* Add Modify server despedency
* Add network setting

##	Installation procedure

step1 : Download and install [Raspbian Legacy DESKTOP](https://downloads.raspberrypi.com/raspios_oldstable_armhf/images/raspios_oldstable_armhf-2023-12-06/2023-12-05-raspios-bullseye-armhf.img.xz?_gl=1*lsl41n*_ga*MTYwNTczNjQyMC4xNzAyOTU1NDg4*_ga_22FD70LWDS*MTcwMzY5OTA1NS4zLjEuMTcwMzY5OTA3Mi4wLjAuMA..) 

step2 : Connect to network 

step3 : Clone the installer and start the installation

      $ git clone https://github.com/bestsolution123/parking-client-installer.git
      $ cd ./parking-client-installer
      $ chmod +x install.sh
      $ sudo ./install.sh

step4 : Wait untill the instalation complete.
step5 : Restart 
step5 : Open Browser and Type [locahost](http://localhost)
