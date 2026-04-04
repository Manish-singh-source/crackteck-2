# Notification Opportunity Map

This file lists the main places in the codebase where `Email`, `OTP`, and `Push Notification` flows can be used or are already natural fits.

| File name and location | Method name | What we can use |
| --- | --- | --- |
| `app/Http/Controllers/FrontendAuthController.php:37` | `sendLoginOtp` | OTP via SMS for customer login verification |
| `app/Http/Controllers/FrontendAuthController.php:80` | `verifyLoginOtp` | Push or email login-success/security alert |
| `app/Http/Controllers/FrontendAuthController.php:119` | `register` | Email welcome/account verification, push onboarding |
| `app/Http/Controllers/FrontendAuthController.php:209` | `ecommerceLogin` | Email or push login alert |
| `app/Http/Controllers/FrontendAuthController.php:249` | `ecommerceSignup` | Email welcome/account verification, push onboarding |
| `app/Http/Controllers/Api/ApiAuthController.php:178` | `sendVerificationCode` | OTP via SMS/email for contact verification |
| `app/Http/Controllers/Api/ApiAuthController.php:215` | `verifyVerificationCode` | Email or push verification-success alert |
| `app/Http/Controllers/Api/ApiAuthController.php:266` | `resendVerificationCode` | OTP resend via SMS/email |
| `app/Http/Controllers/Api/ApiAuthController.php:313` | `sendForgotPasswordCode` | OTP via SMS/email for password reset |
| `app/Http/Controllers/Api/ApiAuthController.php:349` | `verifyForgotPasswordCode` | Email or push password-reset verification success |
| `app/Http/Controllers/Api/ApiAuthController.php:395` | `resendForgotPasswordCode` | OTP resend via SMS/email |
| `app/Http/Controllers/Api/ApiAuthController.php:400` | `resetForgotPassword` | Email password-reset confirmation, push security alert |
| `app/Http/Controllers/Api/ApiAuthController.php:447` | `signup` | Email welcome/verification, push onboarding |
| `app/Http/Controllers/Api/ApiAuthController.php:795` | `login` | OTP via SMS for mobile login |
| `app/Http/Controllers/Api/ApiAuthController.php:871` | `verifyOtp` | Push or email login-success alert |
| `app/Http/Controllers/Api/ApiAuthController.php:1022` | `googleLogin` | Email or push new-login/security alert |
| `app/Http/Controllers/Api/ApiAuthController.php:1105` | `emailPasswordLogin` | Email or push new-login/security alert |
| `app/Http/Controllers/PasswordResetController.php:31` | `sendResetLink` | Email password reset link |
| `app/Http/Controllers/PasswordResetController.php:115` | `resetPassword` | Email password changed confirmation, push security alert |
| `app/Http/Controllers/PasswordResetController.php:184` | `apiSendResetLink` | Email password reset link |
| `app/Http/Controllers/PasswordResetController.php:261` | `apiResetPassword` | Email password changed confirmation, push security alert |
| `app/Http/Controllers/AuthController.php:43` | `loginStore` | OTP verification for staff login |
| `app/Http/Controllers/AuthController.php:104` | `sendOtp` | OTP via SMS/email for staff verification |
| `app/Http/Controllers/AuthController.php:217` | `register` | Email onboarding/welcome |
| `app/Http/Controllers/CheckoutController.php:215` | `store` | Email order confirmation, push order placed |
| `app/Http/Controllers/CheckoutController.php:354` | `createRazorpayOrder` | Email or push payment initiated reminder |
| `app/Http/Controllers/CheckoutController.php:391` | `verifyRazorpayPayment` | Email payment success receipt, push payment success |
| `app/Http/Controllers/CheckoutController.php:703` | `orderDetails` | Email invoice/order summary resend option |
| `app/Http/Controllers/CheckoutController.php:932` | `cancelOrder` | Email cancellation confirmation, push cancellation update |
| `app/Http/Controllers/CheckoutController.php:1001` | `returnOrder` | Email return request confirmation, push return created |
| `app/Http/Controllers/OrderSupportController.php:20` | `cancelOrder` | Email customer/admin cancellation update, push refund status |
| `app/Http/Controllers/OrderSupportController.php:111` | `returnOrder` | Email customer/admin return request update, push return progress |
| `app/Http/Controllers/OrderSupportController.php:312` | `submitReplacement` | Email customer/admin replacement request update, push replacement progress |
| `app/Http/Controllers/OrderSupportController.php:390` | `refundBankDetailsStore` | Email admin/customer refund details submitted confirmation |
| `app/Http/Controllers/AdminOrderSupportController.php:16` | `returnReceive` | Email customer return received update, push warehouse received |
| `app/Http/Controllers/AdminOrderSupportController.php:58` | `completeRefund` | Email refund processed confirmation, push refund completed |
| `app/Http/Controllers/AdminOrderSupportController.php:149` | `updateReplacementStatus` | Email replacement approved/rejected update, push status change |
| `app/Http/Controllers/AdminOrderSupportController.php:194` | `assignReplacementRequest` | Email assignment progress update, push replacement assigned |
| `app/Http/Controllers/Api/OrderController.php:127` | `buyProduct` | Push order placed, email order confirmation |
| `app/Http/Controllers/Api/OrderController.php:338` | `requestProduct` | Email/push internal stock request alert |
| `app/Http/Controllers/Api/OrderController.php:461` | `cancelOrder` | Email cancellation and refund status, push order update |
| `app/Http/Controllers/Api/OrderController.php:505` | `returnOrder` | Email return request confirmation, push return status |
| `app/Http/Controllers/Api/PaymentRefundController.php:14` | `__invoke` | Email refund initiated/completed, push refund status |
| `app/Http/Controllers/Api/RewardClaimController.php:30` | `claimReward` | Email reward claimed confirmation, push reward unlocked |
| `app/Http/Controllers/Api/QuotationController.php:42` | `store` | Email quotation created, push admin/customer quote alert |
| `app/Http/Controllers/Api/QuotationController.php:176` | `update` | Email quotation updated, push customer quote change |
| `app/Http/Controllers/Api/CashReceivedController.php:39` | `store` | Email payment/cash receipt confirmation, push finance update |
| `app/Http/Controllers/Api/AllServicesController.php:209` | `submitQuickServiceRequest` | Email service request created, push engineer/admin alert |
| `app/Http/Controllers/Api/AllServicesController.php:588` | `customerApproveRejectPart` | Email part approval/rejection update, push workflow status |
| `app/Http/Controllers/Api/AllServicesController.php:761` | `acceptQuotation` | Email quotation accepted, push service workflow update |
| `app/Http/Controllers/Api/AllServicesController.php:792` | `rejectQuotation` | Email quotation rejected, push service workflow update |
| `app/Http/Controllers/Api/AllServicesController.php:823` | `payInvoice` | Email invoice payment receipt, push payment success |
| `app/Http/Controllers/Api/AllServicesController.php:988` | `acceptInvoice` | Email invoice accepted, push next-step alert |
| `app/Http/Controllers/Api/AllServicesController.php:1024` | `rejectInvoice` | Email invoice rejected, push follow-up alert |
| `app/Http/Controllers/Api/AllServicesController.php:1061` | `giveFeedback` | Email thank-you or follow-up, push feedback acknowledgment |
| `app/Http/Controllers/Api/AllServicesController.php:1187` | `customerApproveRejectPickup` | Email pickup approval/rejection update, push logistics alert |
| `app/Http/Controllers/Api/AllServicesController.php:1253` | `makeServiceRequestQuotationPayment` | Email payment receipt, push payment confirmation |
| `app/Http/Controllers/FieldEngineerController.php:220` | `acceptServiceRequest` | Push customer/admin engineer assigned or accepted update |
| `app/Http/Controllers/FieldEngineerController.php:247` | `startDiagnosis` | OTP for diagnosis start verification |
| `app/Http/Controllers/FieldEngineerController.php:306` | `verifyDiagnosis` | Push/email diagnosis verification success |
| `app/Http/Controllers/FieldEngineerController.php:403` | `caseTransfer` | Email/push case transferred alert to admin/customer/engineer |
| `app/Http/Controllers/FieldEngineerController.php:674` | `submitDiagnosis` | Email diagnosis submitted, push workflow update |
| `app/Http/Controllers/FieldEngineerController.php:1086` | `requestPart` | Email part requested alert, push internal approval workflow |
| `app/Http/Controllers/Api/DeliveryOrderController.php:75` | `acceptOrder` | Push customer/admin delivery agent assigned/accepted |
| `app/Http/Controllers/Api/DeliveryOrderController.php:223` | `updateOrderOtp` | OTP for delivery handoff verification |
| `app/Http/Controllers/Api/DeliveryOrderController.php:279` | `verifyOrderOtp` | Push delivery completed/verified update |
| `app/Http/Controllers/Api/DeliveryOrderController.php:876` | `acceptReturnOrder` | Push customer/admin return pickup accepted |
| `app/Http/Controllers/Api/DeliveryOrderController.php:922` | `returnOrderOtp` | OTP for return pickup verification |
| `app/Http/Controllers/Api/DeliveryOrderController.php:974` | `verifyReturnOrderOtp` | Push return pickup verified update |
| `app/Http/Controllers/Api/DeliveryOrderController.php:1060` | `receiveReturnOrder` | Email customer return received update, push warehouse update |
| `app/Http/Controllers/Api/KycController.php:74` | `submitKyc` | Email KYC submitted confirmation, push review started |
| `app/Http/Controllers/Api/KycController.php:191` | `updateStatus` | Email KYC approved/rejected/resubmit required, push status change |
| `app/Http/Controllers/MyAccountController.php:513` | `storeAmcTicket` | Email ticket created confirmation, push support alert |
| `app/Http/Controllers/AmcController.php:613` | `rescheduleAmcRequest` | Email reschedule confirmation, push visit change alert |
| `app/Http/Controllers/AmcController.php:644` | `updateTicketStatus` | Email AMC ticket status change, push support progress |
| `app/Http/Controllers/AmcServicesController.php:265` | `assignEngineer` | Push engineer/customer assignment update |
| `app/Http/Controllers/AmcServicesController.php:439` | `assignVisitEngineer` | Push visit assignment alert |
| `app/Http/Controllers/AmcServicesController.php:537` | `updateVisitEngineer` | Email/push visit reassignment or update |
| `app/Http/Controllers/ReturnRequestController.php:145` | `acceptReturnRequest` | Email/push return accepted for processing |
| `app/Http/Controllers/ReturnRequestController.php:225` | `sendReturnOtp` | OTP for return verification |
| `app/Http/Controllers/ReturnRequestController.php:317` | `verifyReturnOtp` | Push/email return verification success |
| `app/Http/Controllers/PickupRequestController.php:159` | `acceptPickupRequest` | Email/push pickup accepted |
| `app/Http/Controllers/PickupRequestController.php:238` | `sendPickupOtp` | OTP for pickup verification |
| `app/Http/Controllers/PickupRequestController.php:328` | `verifyPickupOtp` | Push/email pickup verification success |
| `app/Http/Controllers/PartRequestController.php:118` | `acceptPartRequest` | Email/push part request accepted |
| `app/Http/Controllers/PartRequestController.php:192` | `sendPartRequestOtp` | OTP for part delivery/verification |
| `app/Http/Controllers/PartRequestController.php:285` | `verifyPartRequestOtp` | Push/email part request verification success |
| `app/Services/OrderSupportService.php:75` | `notifyCustomer` | Email customer-facing order, return, refund, replacement updates |
| `app/Services/OrderSupportService.php:84` | `notifyAdmin` | Email admin-facing support, refund, and replacement alerts |
| `app/Services/Fast2smsService.php:26` | `sendOtp` | OTP via SMS transport layer |
| `app/Services/FirebaseFcmService.php:51` | `sendToToken` | Push notification transport layer |
