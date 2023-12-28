//write serial
// serial_port.write("alloff\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// serial_port.write("security on\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// serial_port.write("security off\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// serial_port.write("son1\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// serial_port.write("soff1\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// serial_port.write("on3\n", function (err) {
//   if (err) {
//     return console.log("Error on write: ", err.message);
//   }
//   console.log("message written");
// });

// tester gate in Regular
// fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//   if (data != "") {
//     if (err) throw err;
//     // console.log(data);
//     const options_1 = {
//       method: "GET",
//       headers: {
//         "Content-Type": "application/json",
//         Authorization: data,
//       },
//       url: ip_address + "/api/dashboard/siteGateParking",
//     };
//     axios(options_1).then(function (response_1) {
//       // console.log(response_1);
//       // check last transaction
//       const options_2 = {
//         method: "GET",
//         headers: { "content-type": "application/x-www-form-urlencoded" },
//         url: ip_address + "/api/dashboard/getTransactionLatest",
//       };
//       axios(options_2).then(function (response_2) {
//         // console.log(response_2.data.length + 1);
//         // check vehicle
//         const options_1_check_vehicle = {
//           method: "GET",
//           headers: {
//             "Content-Type": "application/json",
//             Authorization: data,
//           },
//           url: ip_address + "/api/gate/checkVehicle/1701057110823",
//         };
//         axios(options_1_check_vehicle).then(function (response_check_vehicle) {
//           // console.log(response_check_vehicle.data.id);

//           //create transaction
//           const body_3 = {
//             user_id: 1,
//             vehicle_id: response_check_vehicle.data.id,
//             transaction_member_id: 0,
//             // transaction_member_id: 1701058009983,
//             transaction_voucher_id: 0,
//             // transaction_voucher_id: 1701707849285,
//             site_gate_parking_id: response_1.data.id,
//             number: response_2.data.length + 1,
//             plat_number: "5 aCV 999",
//             // plat_number: "5 aCV 000",
//             // plat_number: "F 359 FC",
//             visitor_type: "Regular",
//             // visitor_type: "Member",
//             // visitor_type: "Voucher",
//             gate_out: "-",
//             in_photo: "-",
//             out_photo: "-",
//             status: "-",
//           };
//           const options_3 = {
//             method: "POST",
//             headers: {
//               "content-type": "application/x-www-form-urlencoded",
//               Authorization: data,
//             },
//             data: qs.stringify(body_3),
//             url: ip_address + "/api/gate/scanners",
//           };
//           axios(options_3).then(function (response_3) {
//             console.log(response_3.data);
//             if (response_3.data == "Member Expired") {
//             } else if (response_3.data == "Voucher Expired") {
//             } else {
//               // const options_4 = {
//               //   method: "GET",
//               //   headers: {
//               //     "content-type": "application/x-www-form-urlencoded",
//               //   },
//               //   url:
//               //     ip_address +
//               //     "/api/gate/printParking/" +
//               //     response_1.data.id +
//               //     "/" +
//               //     response_3.data.id,
//               // };
//               // axios(options_4).then(function (response_4) {
//               //   console.log(response_4);
//               //   //play silahkan masuk
//               //   player.play("assets/sound/silahkan_masuk.mp3", function (err) {
//               //     if (err) throw err;
//               //   });
//               // });
//             }
//           });
//         });
//       });
//     });
//   }
// });

// express
// app.get("/", (req, res) => {
//   res.send("Hello World!");
// });

// app.listen(port, () => {
//     console.log(`Example app listening on port ${port}`);
// });

// tester gate in Regular
// fs.readFile("assets/file/token.txt", "utf8", function (err, data) {
//   if (data != "") {
//     if (err) throw err;
//     // console.log(data);
//     const options_1 = {
//       method: "GET",
//       headers: {
//         "Content-Type": "application/json",
//         Authorization: data,
//       },
//       url: ip_address + "/api/dashboard/siteGateParking",
//     };
//     axios(options_1).then(function (response_1) {
//       // console.log(response_1.data.vehicle.serial);
//       // check last transaction
//       const options_2 = {
//         method: "GET",
//         headers: { "content-type": "application/x-www-form-urlencoded" },
//         url: ip_address + "/api/dashboard/getTransactionLatest",
//       };
//       axios(options_2).then(function (response_2) {
//         // console.log(response_2.data.length + 1);
//         // check vehicle
//         const options_1_check_vehicle = {
//           method: "GET",
//           headers: {
//             "Content-Type": "application/json",
//             Authorization: data,
//           },
//           // url: ip_address + "/api/gate/checkVehicle/1701057110823",
//           url:
//             ip_address +
//             "/api/gate/checkVehicle/" +
//             response_1.data.vehicle.serial,
//         };
//         axios(options_1_check_vehicle).then(function (response_check_vehicle) {
//           // console.log(response_check_vehicle);

//           //take capture
//           let cctv_capture_name =
//             getRandomInt(1000) + date_now + "-cctv-captures.png";
//           puppeteer
//             .launch({
//               defaultViewport: {
//                 width: 640,
//                 height: 360,
//               },
//             })
//             .then(async (browser) => {
//               const page = await browser.newPage();
//               await page.goto(cctv_url);
//               await page.screenshot({
//                 path: "../public/storage/cctv/" + cctv_capture_name,
//               });
//               await browser.close();
//             });

//           //create transaction
//           const body_3 = {
//             user_id: 1,
//             vehicle_id: response_check_vehicle.data.id,
//             vehicle_initial_id: response_check_vehicle.data.vehicle_initial_id,
//             transaction_member_id: 0,
//             transaction_voucher_id: 0,
//             site_gate_parking_id: response_1.data.id,
//             number: response_2.data.length + 1,
//             plat_number: "-",
//             visitor_type: "-",
//             gate_out: "-",
//             in_photo: cctv_capture_name,
//             out_photo: "-",
//             status: "-",
//             scanner: keyboard,
//           };
//           const options_3 = {
//             method: "POST",
//             headers: {
//               "content-type": "application/x-www-form-urlencoded",
//               Authorization: data,
//             },
//             data: qs.stringify(body_3),
//             url: ip_address + "/api/gate/scanners",
//           };
//           axios(options_3).then(function (response_3) {
//             // console.log(response_3);
//             if (response_3.data == "Member Expired") {
//             } else if (response_3.data == "Voucher Expired") {
//             } else if (
//               response_3.data == "Tidak Bisa Membuat Transaksi Di Pintu Keluar"
//             ) {
//             } else {
//               // const options_4 = {
//               //   method: "GET",
//               //   headers: {
//               //     "content-type": "application/x-www-form-urlencoded",
//               //     Authorization: data,
//               //   },
//               //   url:
//               //     ip_address + "/api/gate/printParking/" + response_3.data.id,
//               // };
//               // axios(options_4).then(function (response_4) {
//               //   // console.log(response_4);
//               //   //play silahkan masuk
//               //   player.play("assets/sound/silahkan_masuk.mp3", function (err) {
//               //     if (err) throw err;
//               //   });
//               // });
//               // serial_port.write("on1\n", function (err) {
//               //   if (err) {
//               //     return console.log("Error on write: ", err.message);
//               //   }
//               //   console.log("message written");
//               // });
//             }
//           });
//         });
//       });
//     });
//   }
// });
