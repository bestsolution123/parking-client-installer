const express = require("express");
const app = express();

//play sound
var player = require("play-sound")((opts = {}));
// take image
let date_ob = new Date();
// current date
// adjust 0 before single digit date
let date = ("0" + date_ob.getDate()).slice(-2);
// current month
let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
// current year
let year = date_ob.getFullYear();
// current hours
let hours = date_ob.getHours();
// current minutes
let minutes = date_ob.getMinutes();
// current seconds
let seconds = date_ob.getSeconds();
let date_now = year + month + date + hours + minutes + seconds;

function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

//serial port
const { SerialPort } = require("serialport");
const { ReadlineParser } = require("@serialport/parser-readline");
const { default: axios } = require("axios");

// latest
const qs = require("qs");
const fs = require("fs");
app.use(express.static("assets"));
app.use(express.static("views"));
var cron = require("node-cron");
const port = 3000;

const serial_port = new SerialPort({
  path: "/dev/tty.usbserial-14110",
  baudRate: 9600,
});

const ip_address = "http://127.0.0.1:8000";
const server_address = "http://127.0.0.1:8000";
const cctv_url =
  "http://admin:Admin1234@192.168.1.64/Streaming/Channels/1/picture";
// const cctv_url =
//   "http://admin:@bio2022@192.168.1.65/Streaming/Channels/1/picture";

open_gate = false;

// on keyboard scanner
let readline = require("readline");
readline.emitKeypressEvents(process.stdin);
var keyboard = "";

//manless
process.stdin.on("keypress", (ch, key) => {
  // console.log(key.name);
  if (key.name == "return") {
    // console.log(keyboard);

    // tester gate in Member
    fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
      if (data != "") {
        if (err) throw err;
        // console.log(data);
        const options_1 = {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Authorization: data,
          },
          url: ip_address + "/api/dashboard/siteGateParking",
        };
        axios(options_1).then(function (response_1) {
          // console.log(response_1.data.vehicle.serial);
          // check last transaction
          const options_2 = {
            method: "GET",
            headers: { "content-type": "application/x-www-form-urlencoded" },
            url: ip_address + "/api/dashboard/getTransactionLatest",
          };
          axios(options_2).then(function (response_2) {
            // console.log(response_2.data.length + 1);
            // check vehicle
            const options_1_check_vehicle = {
              method: "GET",
              headers: {
                "Content-Type": "application/json",
                Authorization: data,
              },
              // url: ip_address + "/api/gate/checkVehicle/1701057110823",
              url:
                ip_address +
                "/api/gate/checkVehicle/" +
                response_1.data.vehicle.serial,
            };
            axios(options_1_check_vehicle).then(function (
              response_check_vehicle
            ) {
              // console.log(response_check_vehicle);

              // get cctv screenshoot
              let cctv_capture_name =
                getRandomInt(1000) + date_now + "-cctv-captures.png";
              const writer = fs.createWriteStream(
                "../public/storage/cctv/" + cctv_capture_name
              );
              const options_cctv = {
                method: "GET",
                responseType: "stream",
                url: cctv_url,
              };
              axios(options_cctv).then(function (response_cctv) {
                response_cctv.data.pipe(writer);
              });

              //create transaction
              const body_3 = {
                user_id: 1,
                vehicle_id: response_check_vehicle.data.id,
                vehicle_initial_id:
                  response_check_vehicle.data.vehicle_initial_id,
                transaction_member_id: 0,
                transaction_voucher_id: 0,
                site_gate_parking_id: response_1.data.id,
                number: response_2.data.length + 1,
                plat_number: "-",
                visitor_type: "-",
                gate_out: "-",
                in_photo: cctv_capture_name,
                out_photo: "-",
                status: "-",
                scanner: keyboard,
              };
              const options_3 = {
                method: "POST",
                headers: {
                  "content-type": "application/x-www-form-urlencoded",
                  Authorization: data,
                },
                data: qs.stringify(body_3),
                url: ip_address + "/api/gate/scanners",
              };
              axios(options_3).then(function (response_3) {
                // console.log(response_3);
                if (response_3.data == "Member Expired") {
                } else if (response_3.data == "Voucher Expired") {
                } else if (
                  response_3.data ==
                  "Tidak Bisa Membuat Transaksi Di Pintu Keluar"
                ) {
                } else {
                  //play silahkan masuk
                  player.play(
                    "assets/sound/silahkan_masuk.mp3",
                    function (err) {
                      if (err) throw err;
                    }
                  );
                  keyboard = "";

                  serial_port.write("on1\n", function (err) {
                    if (err) {
                      return console.log("Error on write: ", err.message);
                    }
                    // console.log("message written");
                  });
                }
              });
            });
          });
        });
      }
    });
  } else {
    keyboard += key.name;
  }
});

if (process.stdin.isTTY) {
  process.stdin.setRawMode(true);
}

// read serial
const parser = serial_port.pipe(new ReadlineParser({ delimiter: "\r\n" }));
parser.on("data", function (data) {
  // console.log(data);

  if (data == "RelayPin1 = LOW") {
    if (open_gate == true) {
      open_gate = false;
    }
  } else if (data == "print") {
    if (open_gate == false) {
      // get cctv screenshoot
      let cctv_capture_name =
        getRandomInt(1000) + date_now + "-cctv-captures.png";
      const writer = fs.createWriteStream(
        "../public/storage/cctv/" + cctv_capture_name
      );
      const options_cctv = {
        method: "GET",
        responseType: "stream",
        url: cctv_url,
      };
      axios(options_cctv).then(function (response_cctv) {
        response_cctv.data.pipe(writer);
      });

      // tester gate in Regular
      fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
        if (data != "") {
          if (err) throw err;
          // console.log(data);
          const options_1 = {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
              Authorization: data,
            },
            url: ip_address + "/api/dashboard/siteGateParking",
          };
          axios(options_1).then(function (response_1) {
            // console.log(response_1.data.vehicle.serial);
            // check last transaction
            const options_2 = {
              method: "GET",
              headers: { "content-type": "application/x-www-form-urlencoded" },
              url: ip_address + "/api/dashboard/getTransactionLatest",
            };
            axios(options_2).then(function (response_2) {
              // console.log(response_2.data.length + 1);
              // check vehicle
              const options_1_check_vehicle = {
                method: "GET",
                headers: {
                  "Content-Type": "application/json",
                  Authorization: data,
                },
                // url: ip_address + "/api/gate/checkVehicle/1701057110823",
                url:
                  ip_address +
                  "/api/gate/checkVehicle/" +
                  response_1.data.vehicle.serial,
              };
              axios(options_1_check_vehicle).then(function (
                response_check_vehicle
              ) {
                // console.log(response_check_vehicle);

                //create transaction
                const body_3 = {
                  user_id: 1,
                  vehicle_id: response_check_vehicle.data.id,
                  vehicle_initial_id:
                    response_check_vehicle.data.vehicle_initial_id,
                  transaction_member_id: 0,
                  transaction_voucher_id: 0,
                  site_gate_parking_id: response_1.data.id,
                  number: response_2.data.length + 1,
                  plat_number: "-",
                  visitor_type: "-",
                  gate_out: "-",
                  in_photo: cctv_capture_name,
                  out_photo: "-",
                  status: "-",
                  scanner: keyboard,
                };
                const options_3 = {
                  method: "POST",
                  headers: {
                    "content-type": "application/x-www-form-urlencoded",
                    Authorization: data,
                  },
                  data: qs.stringify(body_3),
                  url: ip_address + "/api/gate/scanners",
                };
                axios(options_3).then(function (response_3) {
                  // console.log(response_3.data);
                  if (response_3.data == "Member Expired") {
                  } else if (response_3.data == "Voucher Expired") {
                  } else if (
                    response_3.data ==
                    "Tidak Bisa Membuat Transaksi Di Pintu Keluar"
                  ) {
                  } else {
                    const options_4 = {
                      method: "GET",
                      headers: {
                        "content-type": "application/x-www-form-urlencoded",
                        Authorization: data,
                      },
                      url:
                        ip_address +
                        "/api/gate/printParking/" +
                        response_3.data.id,
                    };
                    axios(options_4).then(function (response_4) {
                      console.log(response_4);
                      //play silahkan masuk
                      player.play(
                        "assets/sound/silahkan_masuk.mp3",
                        function (err) {
                          if (err) throw err;
                        }
                      );
                    });

                    serial_port.write("on1\n", function (err) {
                      if (err) {
                        return console.log("Error on write: ", err.message);
                      }
                      // console.log("message written");
                    });
                  }
                });
              });
            });
          });
        }
      });

      open_gate = true;
    }
  } else if (data == "help") {
    //play bantuan
    player.play("assets/sound/bantuan.mp3", function (err) {
      if (err) throw err;
    });
  } else if (data == "welcome") {
    //play welcome
    player.play("assets/sound/welcome.mp3", function (err) {
      if (err) throw err;
    });
  } else if (data == "security on") {
    //play security on
    // player.play("assets/sound/welcome.mp3", function (err) {
    //   if (err) throw err;
    // });
  } else if (data == "security off") {
    //play security off
    player.play("assets/sound/welcome.mp3", function (err) {
      if (err) throw err;
    });
  } else if (data == "qrcode") {
    //play security off

    const options_2 = {
      method: "GET",
      headers: { "content-type": "application/x-www-form-urlencoded" },
      url: ip_address + "/api/dashboard/siteGateParking",
    };
    axios(options_2).then(function (response_1) {
      const body_3 = {
        serial: "1698610424705",
        status: "Belum Membayar",
        gate_out: response_1.data.name,
      };
      const options_3 = {
        method: "POST",
        headers: {
          "content-type": "application/x-www-form-urlencoded",
        },
        data: qs.stringify(body_3),
        url: ip_address + "/api/qrcode/scanners",
      };
      axios(options_3).then(function (response_3) {
        // console.log(response_3);
        const options_4 = {
          method: "GET",
          headers: {
            "content-type": "application/x-www-form-urlencoded",
          },
          url: ip_address + "/api/gate/printParkingExit/" + response_3.data.id,
        };

        axios(options_4).then(function (response_4) {
          // console.log(response_4);
          //play silahkan masuk
          player.play("assets/sound/silahkan_masuk.mp3", function (err) {
            if (err) throw err;
          });
        });
      });
    });
  }
});

//get local data from server once before login
// const options_1_get_all_data = {
//   method: "GET",
//   headers: {
//     "Content-Type": "application/json",
//   },
//   // url: ip_address + "/api/gate/checkVehicle/1701057110823",
//   url: server_address + "/api/gate/transaction/getAllData",
// };
// axios(options_1_get_all_data).then(function (response_get_all_data) {
//   // console.log(response_get_all_data);
//   //create transaction
//   const body_3 = {
//     gate_parking_type: "-",
//     manlessPayment: response_get_all_data.data.manlessPayment,
//     member: response_get_all_data.data.member,
//     member_plat_number: response_get_all_data.data.member_plat_number,
//     printer: response_get_all_data.data.printer,
//     printer_setting: response_get_all_data.data.printer_setting,
//     punishment: response_get_all_data.data.punishment,
//     site_gate_parking: response_get_all_data.data.site_gate_parking,
//     siteGateParkingPayment: response_get_all_data.data.siteGateParkingPayment,
//     transaction: response_get_all_data.data.transaction,
//     transaction_member: response_get_all_data.data.transaction_member,
//     transaction_voucher: response_get_all_data.data.transaction_voucher,
//     User: response_get_all_data.data.User,
//     vehicle: response_get_all_data.data.vehicle,
//     vehicle_initial: response_get_all_data.data.vehicle_initial,
//     voucher: response_get_all_data.data.voucher,
//     voucher_plat_number: response_get_all_data.data.voucher_plat_number,
//   };
//   const options_3 = {
//     method: "POST",
//     headers: {
//       "content-type": "application/x-www-form-urlencoded",
//     },
//     data: qs.stringify(body_3),
//     url: ip_address + "/api/gate/transaction/storeAllData",
//   };
//   axios(options_3).then(function (response_3) {
//     // console.log(response_3);
//   });
// });

//get local data from server
// cron.schedule("*/10 * * * * *", () => {
//   fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//     if (data != "") {
//       if (err) throw err;
//       // console.log(data);
//       const options_1 = {
//         method: "GET",
//         headers: {
//           "Content-Type": "application/json",
//           Authorization: data,
//         },
//         url: ip_address + "/api/dashboard/siteGateParking",
//       };
//       axios(options_1).then(function (response_1) {
//         // console.log(response_1.data.type);
//         // check last transaction
//         const options_1_get_all_data = {
//           method: "GET",
//           headers: {
//             "Content-Type": "application/json",
//           },
//           // url: ip_address + "/api/gate/checkVehicle/1701057110823",
//           url: server_address + "/api/gate/transaction/getAllData",
//         };
//         axios(options_1_get_all_data).then(function (response_get_all_data) {
//           // console.log(response_get_all_data);
//           //create transaction
//           const body_3 = {
//             gate_parking_type: response_1.data.type,
//             manlessPayment: response_get_all_data.data.manlessPayment,
//             member: response_get_all_data.data.member,
//             member_plat_number: response_get_all_data.data.member_plat_number,
//             printer: response_get_all_data.data.printer,
//             printer_setting: response_get_all_data.data.printer_setting,
//             punishment: response_get_all_data.data.punishment,
//             site_gate_parking: response_get_all_data.data.site_gate_parking,
//             siteGateParkingPayment:
//               response_get_all_data.data.siteGateParkingPayment,
//             transaction: response_get_all_data.data.transaction,
//             transaction_member: response_get_all_data.data.transaction_member,
//             transaction_voucher: response_get_all_data.data.transaction_voucher,
//             User: response_get_all_data.data.User,
//             vehicle: response_get_all_data.data.vehicle,
//             vehicle_initial: response_get_all_data.data.vehicle_initial,
//             voucher: response_get_all_data.data.voucher,
//             voucher_plat_number: response_get_all_data.data.voucher_plat_number,
//           };
//           const options_3 = {
//             method: "POST",
//             headers: {
//               "content-type": "application/x-www-form-urlencoded",
//             },
//             data: qs.stringify(body_3),
//             url: ip_address + "/api/gate/transaction/storeAllData",
//           };
//           axios(options_3).then(function (response_3) {
//             // console.log(response_3);
//           });
//         });
//       });
//     }
//   });
// });

//send data transaction to server
// cron.schedule("*/10 * * * * *", () => {
//   fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//     if (data != "") {
//       if (err) throw err;
//       // check last transaction

//       const options_1 = {
//         method: "GET",
//         headers: {
//           "Content-Type": "application/json",
//           Authorization: data,
//         },
//         url: ip_address + "/api/dashboard/siteGateParking",
//       };
//       axios(options_1).then(function (response_1) {
//         // console.log(response_1.data.type);
//         // check last transaction
//         const options_2 = {
//           method: "GET",
//           headers: { "content-type": "application/x-www-form-urlencoded" },
//           url: ip_address + "/api/dashboard/getTransactionLatest",
//         };
//         axios(options_2).then(function (response_2) {
//           // console.log(response_2.data);
//           // create transaction
//           const body_3 = {
//             gate_parking_type: response_1.data.type,
//             data: response_2.data,
//           };
//           const options_3 = {
//             method: "POST",
//             headers: {
//               "content-type": "application/x-www-form-urlencoded",
//             },
//             data: qs.stringify(body_3),
//             url: server_address + "/api/gate/transaction/cron",
//           };
//           axios(options_3).then(function (response_3) {
//             // console.log(response_3);
//           });
//         });
//       });
//     }
//   });
// });

//update data transaction to server
// cron.schedule("*/10 * * * * *", () => {
//   fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//     if (data != "") {
//       if (err) throw err;
//       // check last transaction

//       const options_1 = {
//         method: "GET",
//         headers: {
//           "Content-Type": "application/json",
//           Authorization: data,
//         },
//         url: ip_address + "/api/dashboard/siteGateParking",
//       };
//       axios(options_1).then(function (response_1) {
//         // console.log(response_1.data.type);
//         // check last transaction
//         const options_2 = {
//           method: "GET",
//           headers: { "content-type": "application/x-www-form-urlencoded" },
//           url: ip_address + "/api/dashboard/getTransactionLatest",
//         };
//         axios(options_2).then(function (response_2) {
//           // console.log(response_2.data);
//           // create transaction
//           const body_3 = {
//             gate_parking_type: response_1.data.type,
//             data: response_2.data,
//           };
//           const options_3 = {
//             method: "POST",
//             headers: {
//               "content-type": "application/x-www-form-urlencoded",
//             },
//             data: qs.stringify(body_3),
//             url: server_address + "/api/gate/transaction/cron/update",
//           };
//           axios(options_3).then(function (response_3) {
//             // console.log(response_3);
//           });
//         });
//       });
//     }
//   });
// });

//send data take capture to server
// cron.schedule("*/10 * * * * *", () => {
//   fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//     if (data != "") {
//       if (err) throw err;
//       // check last transaction

//       const options_1 = {
//         method: "GET",
//         headers: {
//           "Content-Type": "application/json",
//           Authorization: data,
//         },
//         url: ip_address + "/api/dashboard/siteGateParking",
//       };
//       axios(options_1).then(function (response_1) {
//         // console.log(response_1.data.type);
//         // check last transaction
//         const body_2 = {
//           gate_parking_type: response_1.data.type,
//         };
//         const options_2 = {
//           method: "POST",
//           headers: {
//             "content-type": "application/x-www-form-urlencoded",
//           },
//           url: ip_address + "/api/gate/transaction/proccessFileCamera",
//           data: qs.stringify(body_2),
//         };
//         axios(options_2).then(function (response_2) {
//           // console.log(response_2);
//         });
//       });
//     }
//   });
// });

//url
app.get("/", (req, res) => {
  res.sendFile("./login.html", { root: __dirname });
});

app.get("/dashboard", (req, res) => {
  res.sendFile("./index.html", { root: __dirname });
});

app.get("/dashboard/manless", (req, res) => {
  res.sendFile("./index_manless.html", { root: __dirname });
});

app.get("/writeFile", (req, res) => {
  // console.log(req.query.token);
  fs.writeFile("assets/file/token.txt", "Bearer " + req.query.token, (err) => {
    if (err) {
      console.error(err);
    }
    // file written successfully
  });
  fs.writeFile(
    "assets/file/type_payment.txt",
    req.query.type_payment,
    (err) => {
      if (err) {
        console.error(err);
      }
      // file written successfully
    }
  );
});

app.get("/emptyFile", (req, res) => {
  fs.writeFile("assets/file/token.txt", "", (err) => {
    if (err) {
      console.error(err);
    }
    // file written successfully
  });
});

app.get("/openGate/out", (req, res) => {
  // console.log(req.query.serial);

  // get cctv screenshoot
  let cctv_capture_name = getRandomInt(1000) + date_now + "-cctv-captures.png";
  const writer = fs.createWriteStream(
    "../public/storage/cctv/" + cctv_capture_name
  );
  const options_cctv = {
    method: "GET",
    responseType: "stream",
    url: cctv_url,
  };
  axios(options_cctv).then(function (response_cctv) {
    response_cctv.data.pipe(writer);
  });

  const body_3 = {
    out_photo: cctv_capture_name,
    serial: req.query.serial,
  };
  const options_3 = {
    method: "POST",
    headers: {
      "content-type": "application/x-www-form-urlencoded",
    },
    data: qs.stringify(body_3),
    url: ip_address + "/api/gate/transaction/outCamera/update",
  };
  axios(options_3).then(function (response_3) {
    // console.log(response_3);
  });

  //open gate
  serial_port.write("on1\n", function (err) {
    if (err) {
      return console.log("Error on write: ", err.message);
    }
    console.log("message written");
  });
});

app.get("/openGate/in", (req, res) => {
  // console.log(req.query.serial);

  // get cctv screenshoot
  let cctv_capture_name = getRandomInt(1000) + date_now + "-cctv-captures.png";
  const writer = fs.createWriteStream(
    "../public/storage/cctv/" + cctv_capture_name
  );
  const options_cctv = {
    method: "GET",
    responseType: "stream",
    url: cctv_url,
  };
  axios(options_cctv).then(function (response_cctv) {
    response_cctv.data.pipe(writer);
  });

  const body_3 = {
    out_photo: cctv_capture_name,
    serial: req.query.serial,
  };
  const options_3 = {
    method: "POST",
    headers: {
      "content-type": "application/x-www-form-urlencoded",
    },
    data: qs.stringify(body_3),
    url: ip_address + "/api/gate/transaction/inCamera/update",
  };
  axios(options_3).then(function (response_3) {
    // console.log(response_3);
  });

  //open gate
  serial_port.write("on1\n", function (err) {
    if (err) {
      return console.log("Error on write: ", err.message);
    }
    // console.log("message written");
  });
});

// start the server
app.listen(port);
console.log("Server started! At http://localhost:" + port);
