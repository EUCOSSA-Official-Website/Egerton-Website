[33m0f565b8[m[33m ([m[1;36mHEAD -> [m[1;32mmain[m[33m, [m[1;31morigin/main[m[33m)[m ..........
[33m270f185[m ...
[33m0630d0a[m ww
[33m97b7160[m yml
[33m692e47d[m YML
[33m3e7acb9[m .
[33mcc0a67e[m Tried to fix the .yml file.
[33mde72f9f[m Made the join button point to how to register for EUCOSSA.
[33m781eded[m Implemented notifications for people within the system so when they pay for the events a receipt number and receipt may be generated.
[33m0909be2[m Adjusted the yml file to ensure errors happening due to package differences are handled.
[33m86ac43e[m The Event Payment success notification is now synchronous.
[33m2e76280[m tried to fix pusher.
[33m221ed2c[m Modified the yml file to accomodate for pushers features.
[33mb71d024[m Implemented Payments and real time notifications through Laravel Pusher. A Queue worker needs to be implemented though.
[33mc6d59ce[m Implemented sweet alerts responses for payments made instead of the JSON responses.
[33m00edcfe[m Added email field to EventRegistration Form.
[33md13e7bd[m Implemented sweet alert for notifications.
[33m7dc5f07[m Fixed validation for users with numbers starting with 01....
[33mb7e6b5a[m The registration process is now collecting user registration numbers and their passwords for google users.
[33m4f57c6f[m Fixed the Image carousel Logic on the screen now it is working.
[33m1404a64[m Restored
[33mf1bc488[m Fabi Ni mnoma
[33m7cf51af[m Updated the balance controller.
[33me0f423a[m Made a carousel on home page.
[33mccae006[m MAde a carousel on home page.
[33mb7eb9a2[m Made the users table in the admin dashboard.
[33mc5f7adf[m The editing UI has now been implemented.
[33m978abd1[m Added events editing functionality to the website.
[33m3de79ce[m Fixed the date formatting in an events show page.
[33mb5a3b16[m Fixed a bug in the analytics page.
[33m1d0fc57[m Updated the sites home page to show upcomming users how to register to the club in order to be an upcomming member.
[33m13c204e[m Sorted the events display on the home page by the event day so the biggest event days are displayed first on the site.
[33mcc584b3[m Fixed the bug that prevented the events creation to be done without the event charges field.
[33m5e4e2d8[m Restored the site.
[33m1b9f433[m Deon ni fala.
[33m288cd9d[m Used data tables in analytics
[33m722f3e9[m Updated the speakers show view to now use datatables.
[33m4cd5242[m Updated the finances tables to use datatables.
[33m2ba061c[m Added the prefered name to the databases Event registration to help out with the names of people who register for events.
[33mf876f84[m Removed unnecessary onmounted code in the Event Attendees  page as it was slowing down the application.
[33mf0fdf36[m Made the popup modal for getting the hackathons ticket and submiting it to database.
[33m6220674[m Utilized datatables to display information through tables.
[33m4fd5289[m Updated the .env.example to reflect the current state of the environment variables.
[33m2dac97d[m The deployment test is working and it has been tested!
[33mb349a78[m .
[33m750445d[m .
[33m272fb19[m .
[33m4468470[m .
[33m4458f07[m Updated the yml to fit Inertia changes.
[33md743b25[m Create cpanelDeployment.yml
[33mb711091[m Fixed the error that made production vue js not to work by introduction of optional chaining to the event card, also testing the production app locally helped alot.
[33m1ed0cfb[m Removed dd commands from the site to prepare for deployment.
[33md7360e0[m Optimized the sites images to make them occupy lesser space for the sites performance.
[33m4cf1b6a[m Adjusted the sites Readme to reflect EUCOSSA's about.
[33m36fed25[m Also made the payments route production proof. i.e for test, I can test with 1 shilling, for production, I will test with 50 shillings.
[33mc70e782[m Production proofed the mpesa implementation by specifying the credentials to be used for test and those for production.
[33m7c0124f[m Fixed a small css bug.
[33m87ed934[m The mpesa routes are now returning session message responses instead of JSON ones.
[33m0ef4da0[m Fixed the bug that didn't allow users to successfully register.
[33mba5325c[m Successfully made flash toast messages dispayable in the application.
[33ma0b8fc8[m The delete buffers for my application is now working.
[33m0cb9ddd[m Implemented the ribbons feature for the home page as recommended by madam Noela.
[33me085168[m Removed the sites darkmode capabilities with the help of Regex.
[33mc525621[m Remember me functionality is working.
[33m64674e6[m Checking the sites money balances is now possible.
[33m3f2c5e6[m The balances are being successfully passed to the UI.
[33m977853a[m The Mpesa balances are now being stored successfully in the database.
[33m9a6cec4[m Updated the .env.example to reflect the balance API username and password.
[33mb31a564[m The balances are now being returned from Mpesa, now only the displaying to UI is working.
[33mb9ca455[m Fixed a bug that prevented a user from accessing an individual event if their unauthenticated.
[33m68e7b8f[m Updated example.enve to have MPesa Credentials.
[33mc92d0da[m Getting the balance from Safaricom is now working.
[33m93557c6[m Passed hackathon badges the the user interface.
[33m77a953e[m Worked on the event attendees page and now the dashboard has the page with event attendees.
[33me9e099a[m Finished up with the event payment logic.
[33md2ce06c[m Improved the overall user experience for the app by making all pages initially accessible for non authenticated users.
[33m299bcb6[m Removed an unnecessary page from my application.
[33m53fbc49[m The first part of the registering on Mpesa is now working.
[33m33616c3[m Introduced the Event Registration model along with its migrations.
[33m144cdd2[m Started to work on the Event processing function.
[33m1ef248b[m Continued with the events registration functions.
[33mf44f63b[m Added an individual share page view to the to the website and now it saves an event link to the clipboard.
[33m2a1dcde[m Added a category field to the Event creation controller and its views and models.
[33mcb6c284[m Implemented the registering for an event and the deleting functionality.
[33mcdc4d44[m Fixed a bug in the authenticated layout wrapper.
[33m82099cd[m Started on the backend of the registering for an event.
[33m21e4228[m Removed the duplicate create event page.
[33m52df2e9[m Implemented an amount input in the event page for people to register for events with money.
[33me9e700a[m Made a random number generator to decide the tasks which I am going to do from my tasklist.
[33me679573[m UI improvements for the speakers show page.
[33ma88a84c[m Added UI improvements to the show views.
[33maa7e6bc[m Made the carousel in the home page work.
[33mb1e45f0[m Improved the check balance method for the daraja API.
[33ma0b1218[m Began the process of checking the mpesa balance.
[33m1a1f354[m The email from the faqs contact page is also now properly formatted and uses a mailable class.
[33mb8da302[m Finished formatting the Event Email.
[33me9590c4[m Styled the email for when events are created. Waiting to style the faqs one.
[33mec3624e[m User interface improvement to help the admins know that there are speaker applications created.
[33m6ead207[m Set my email views to be manually formatted.
[33m3d2d47d[m Implemented badges for the speakers approval pages and also a badge for the main navbar and another badge for the admin dashboard navbar.
[33mcd815da[m Small UI change.
[33maeca6a6[m Implemented deleting in the speakers in the page from the dashboard.
[33m0853c69[m Implemented approval/disapproval functionality for my website's backend.
[33mbfce56a[m The notification counts are now available to the main dashboard!
[33m7d2fca7[m Successfully passed the unread messages count to the view and is now on the header.
[33m62daf76[m Made the post route that helps mark notifications as read.
[33meb6c8e1[m The database notifications are now displayed to the analytics page in the admin dashboard.
[33mb54bbc1[m The feedback from the users in the faqs form is now stored in the database and also an email is sent out.
[33me4f9526[m Fixed a bug in the event card.
[33mef27ff1[m Small UI change in the events show page.
[33m07bc5c9[m Made the show page for a single event and styled it for mobile responsiveness.
[33mc63fb7b[m UI improvement for users to know they are still in the events page.
[33mff880f2[m Did the route grouping inside of the web.php and grouped together all the routes asscociated to the dashboard group.
[33m88b530e[m The Dashboard route is now mobile responsive, has its own navbar link and a fresh image for the dashboard home.
[33m3648671[m Wrapped the administrative views with the admin dashboard view.
[33m488c7d4[m Moved all the administrative functions and views to the dashboard's folder and wrapped them all with the dashboard view.
[33mb1bcabf[m Made the dashboard page reusable and now it can wrap many other components.
[33mb28a438[m Made the show page for the events posted.
[33m0eecbd3[m Began the creation of the attendees page.
[33mbcbc3d8[m Styled a proper reach out form in the faqs page.
[33m2e6e15a[m used the find or fail method instead of fetching a speaker directly.
[33m602dba8[m Made UI changes.
[33ma4b9db1[m Added gate authorization to the show method of the Speakers Controller.
[33m4635eba[m Added the Check balance method to the MPESA controller.
[33m37373c5[m Added the Paystack Controller.
[33m052d1de[m Added the finances view to the Admin Dashboard.
[33m0ee0e24[m Added a background image to the apply for speakers form.
[33m7e0ad1f[m Made the header consistent with the sites theme for the dashboard.
[33m17312b2[m Styled the Show page of the speakers better.
[33mb7b1d9a[m Styled the Create Event page better.
[33md9a13d2[m Started on the show page of a single applicants data from the admin dashboard.
[33m13f60e5[m Moved the Create form from the Event.vue page to the Event/Create.vue page as per Laravels Convention.
[33m796d6ca[m Added navigation to the Create Event page.
[33m8f2b3f2[m Fixed spacing in the vue components.
[33m6998f4f[m The dashboard table is now fixed.
[33m53c193b[m Passed speakers data to the admin dashboard.
[33m11d7718[m Fixed the footer margin error.
[33m7d8033d[m Made the controller to process mpesa donations even by unregistered users.
[33m48c530e[m Began the first part of making donations to database, the rest will be later continued.
[33mcc9ab78[m Made logic to see whether the user has registered in the fall/ spring semester.
[33m27ed472[m The registrations Logic is now in place and the amount can be successfully logged to database.
[33md741b74[m Started working on the Semesterwise Subscriptions.
[33m550e147[m Made the Mpesa Controller for processing registration payments.
[33m09a5982[m Made the Mpesa Checkout ID get registered to the Database.
[33m7be6bab[m Added a checkout column to my users database.
[33mba46e2d[m Made a correction.
[33m5d4f9f2[m Started on the Registration Logic by paying through MPESA.
[33m1abe875[m Made the register controller start to work.
[33mb338a96[m Styled the payments page.
[33m8f68cdf[m Made the about and the Terms and conditions page.
[33m399da46[m Made the correction to fix the MPESA bug.
[33mf139aa1[m Small UI improvements.
[33m1ef6d0d[m Small UI improvements.
[33m4b20b29[m Made the sites FAQ's Page.
[33m07a80c1[m Made the sites footer.
[33m9b48b89[m Was able to log responses from MPESA to text file by disabling that route from CSRF protection.
[33mc2ab848[m The call for speakers form is now fully functional, it submits data to the database, other methods like show and index will be implemented later.
[33m487121c[m Made the create form for the call for speakers.
[33m560e5c2[m Started styling and making the dashboard view.
[33m97a5930[m Implemented email sending on my platform, once Every Thursday and the other time when an event is created.
[33m0464d3f[m The STK push is now working but it is not fully functional.
[33ma2f8878[m Started the stk push process, waiting for error fixing from Safaricom.
[33m38450ad[m Began working on receiving response from MPESA through ngrok. The Online EUCOSSA app is working.
[33m83577c5[m The events can now be uploaded using a form.
[33m3f32954[m Created the event input form for my site.
[33m7c45364[m Started making a guest vue / view.
[33m997340f[m Installed debugbar for debugging the laravel appliation.
[33m4c39397[m The Liking functionality of events by individual users and the events count  is now functional.
[33mca7dbe3[m Prepared application for Daraja.
[33m16000d8[m Worked on the liking of events, from the backend to the frontend.
[33m5ac98cf[m Implemented an inline authorization to the dashboard through a gate.
[33m2e0d55f[m Made the dashboard view, yet to implement the dashboard.
[33mbc3d97e[m Made the animation logic for the home page.
[33m3a0bc15[m Made the events controller, and the index page of the events page for now.
[33m54052aa[m Implemented google avatar logic to the platform.
[33m3973d99[m Made a UI improvement.
[33m4f83ab2[m Passed some events to the dashboard view of my application.
[33m68d8b32[m Made the events model for my event project.
[33mcab286f[m Made UI improvements to my application.
[33m3d773b9[m Fixed the radio group problem on the site as well as its header image element.
[33md365f25[m Installed a mast-head on the sites home page.
[33m08822e4[m Worked on the show password component utilizing vue's props and javascript logic.
[33mf45bdb8[m Added a mobile number field for both registering and loging in.
[33m6384f8f[m Added the initial favicon Icon.
[33m7a7068b[m Implemented the initial version of the Google form.
[33m29fca1e[m Worked on the  Registration Logic and the views that use Google for auth.
[33m8c4b80e[m Fixed the EUCOSSA logo, it is now nice.
[33md3d31e5[m The google login is now working, waiting for the migration for password field nulling.
[33m6e6aa8f[m Made the google auth work, still some way to go.
[33mb91c836[m Imported both laravel breeze for vue and laravel socialite. Yet to test socialite.
[33m51f155a[m First Commit: The site uses Vue.js Inertia Laravel and tailwind.
