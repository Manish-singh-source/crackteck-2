@extends('frontend/layout/master')

@section('main-content')
    <!-- Breakcrumbs -->
    <div class="tf-sp-1 pb-3">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ route('website') }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">Privacy Policy</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <section class="s-search-faq">
        <div class="wrap">
            <div class="container">
                <div class="content">
                    <div class="box-title text-center">
                        <h2 class="title fw-semibold text-white" style="filter: drop-shadow(2px 4px 6px black);">Privacy Policy
                        </h2> 
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax-image">
            <img src="{{ asset('frontend-assets/images/banner/bg-banner-1.jpg') }}"
                data-src="{{ asset('frontend-assets/images/banner/bg-banner-1.jpg') }}" alt=""
                class="lazyload effect-paralax">
        </div>
    </section>    

    <!-- Privacy -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="privary-wrap">
                <div class="entry-privary">

                    <!-- Introduction Card -->
                    <div class="policy-card mb-4">
                        <div class="policy-icon">
                            <i class="icon icon-document"></i>
                        </div>
                        <div class="policy-content">
                            <h5 class="fw-semibold">Privacy Policy</h5>
                            <p class="text-muted mb-0">Please read these Privacy Policy carefully before using our
                                platform.</p>
                        </div>
                    </div>

                    <!-- Terms List -->
                    <div class="terms-section">
                        <div class="term-item">
                            <div class="term-number">1</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Introduction</h6>
                                <p class="text-muted mb-0">
                                    This Privacy Policy describes how 9607788836 and its affiliates (collectively "9607788836, we, our, us") collect, use, share, protect or otherwise process your information/ personal data through our website www.srbcomputers.com (hereinafter referred to as Platform). Please note that you may be able to browse certain sections of the Platform without registering with us.We do not offer any product/service under this Platform outside India and your personal data will primarily be stored and processed in India. By visiting this Platform, providing your information or availing any product/service offered on the Platform, you expressly agree to be bound by the terms and conditions of this Privacy Policy, the Terms of Use and the applicable service/product terms and conditions, and agree to be governed by the laws of India including but not limited to the laws applicable to data protection and privacy. If you do not agree please do not use or access our Platform.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">2</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Collection</h6>
                                <p class="text-muted mb-0">
                                    We collect your personal data when you use our Platform, services or otherwise interact with us during the course of our relationship.and related information provided from time to time. Some of the information that we may collect includes but is not limited to personal data / information provided to us during sign-up/registering or using our Platform such as name, date of birth, address, telephone/mobile number, email IDand/or any such information shared as proof of identity or address. Some of the sensitive personal data may be collected with your consent, such as your bank account or credit or debit card or other payment instrument information or biometric information such as your facial features or physiological information (in order to enable use of certain features when opted for, available on the Platform) etc all of the above being in accordance with applicable law(s) You always have the option to not provide information, by choosing not to use a particular service or feature on the Platform. We may track your behaviour, preferences, and other information that you choose to provide on our Platform. This information is compiled and analysed on an aggregated basis. We will also collect your information related to your transactions on Platform and such third-party business partner platforms. When such a third-party business partner collects your personal data directly from you, you will be governed by their privacy policies. We shall not be responsible for the third-party business partner’s privacy practices or the content of their privacy policies, and we request you to read their privacy policies prior to disclosing any information. If you receive an email, a call from a person/association claiming to be 9607788836 seeking any personal data like debit/credit card PIN, net-banking or mobile banking password, we request you to never provide such information. If you have already revealed such information, report it immediately to an appropriate law enforcement agency.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">3</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Usage</h6>
                                <p class="text-muted mb-0">
                                    We use personal data to provide the services you request. To the extent we use your personal data to market to you, we will provide you the ability to opt-out of such uses. We use your personal data to assist sellers and business partners in handling and fulfilling orders; enhancing customer experience; to resolve disputes; troubleshoot problems; inform you about online and offline offers, products, services, and updates; customise your experience; detect and protect us against error, fraud and other criminal activity; enforce our terms and conditions; conduct marketing research, analysis and surveys; and as otherwise described to you at the time of collection of information. You understand that your access to these products/services may be affected in the event permission is not provided to us.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">4</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Sharing</h6>
                                <p class="text-muted mb-0">
                                    We may share your personal data internally within our group entities, our other corporate entities, and affiliates to provide you access to the services and products offered by them. These entities and affiliates may market to you as a result of such sharing unless you explicitly opt-out. We may disclose personal data to third parties such as sellers, business partners, third party service providers including logistics partners, prepaid payment instrument issuers, third-party reward programs and other payment opted by you. These disclosure may be required for us to provide you access to our services and products offered to you, to comply with our legal obligations, to enforce our user agreement, to facilitate our marketing and advertising activities, to prevent, detect, mitigate, and investigate fraudulent or illegal activities related to our services. We may disclose personal and sensitive personal data to government agencies or other authorised law enforcement agencies if required to do so by law or in the good faith belief that such disclosure is reasonably necessary to respond to subpoenas, court orders, or other legal process. We may disclose personal data to law enforcement offices, third party rights owners, or others in the good faith belief that such disclosure is reasonably necessary to: enforce our Terms of Use or Privacy Policy; respond to claims that an advertisement, posting or other content violates the rights of a third party; or protect the rights, property or personal safety of our users or the general public.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">5</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Security Precautions</h6>
                                <p class="text-muted mb-0">
                                    To protect your personal data from unauthorised access or disclosure, loss or misuse we adopt reasonable security practices and procedures. Once your information is in our possession or whenever you access your account information, we adhere to our security guidelines to protect it against unauthorised access and offer the use of a secure server. However, the transmission of information is not completely secure for reasons beyond our control. By using the Platform, the users accept the security implications of data transmission over the internet and the World Wide Web which cannot always be guaranteed as completely secure, and therefore, there would always remain certain inherent risks regarding use of the Platform. Users are responsible for ensuring the protection of login and password records for their account.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">6</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Data Deletion and Retention</h6>
                                <p class="text-muted mb-0">
                                    You have an option to delete your account by visiting your profile and settings on our Platform , this action would result in you losing all information related to your account. You may also write to us at the contact information provided below to assist you with these requests. We may in event of any pending grievance, claims, pending shipments or any other services we may refuse or delay deletion of the account. Once the account is deleted, you will lose access to the account. We retain your personal data information for a period no longer than is required for the purpose for which it was collected or as required under any applicable law. However, we may retain data related to you if we believe it may be necessary to prevent fraud or future abuse or for other legitimate purposes. We may continue to retain your data in anonymised form for analytical and research purposes.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">7</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Your Rights</h6>
                                <p class="text-muted mb-0">
                                    You may access, rectify, and update your personal data directly through the functionalities provided on the Platform.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">8</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Consent</h6>
                                <p class="text-muted mb-0">
                                    By visiting our Platform or by providing your information, you consent to the collection, use, storage, disclosure and otherwise processing of your information on the Platform in accordance with this Privacy Policy. If you disclose to us any personal data relating to other people, you represent that you have the authority to do so and permit us to use the information in accordance with this Privacy Policy. You, while providing your personal data over the Platform or any partner platforms or establishments, consent to us (including our other corporate entities, affiliates, lending partners, technology partners, marketing channels, business partners and other third parties) to contact you through SMS, instant messaging apps, call and/or e-mail for the purposes specified in this Privacy Policy. You have an option to withdraw your consent that you have already provided by writing to the Grievance Officer at the contact information provided below. Please mention “Withdrawal of consent for processing personal data” in your subject line of your communication. We may verify such requests before acting on our request. However, please note that your withdrawal of consent will not be retrospective and will be in accordance with the Terms of Use, this Privacy Policy, and applicable laws. In the event you withdraw consent given to us under this Privacy Policy, we reserve the right to restrict or deny the provision of our services for which we consider such information to be necessary.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">9</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Changes to this Privacy Policy</h6>
                                <p class="text-muted mb-0">
                                    Please check our Privacy Policy periodically for changes. We may update this Privacy Policy to reflect changes to our information practices. We may alert / notify you about the significant changes to the Privacy Policy, in the manner as may be required under applicable laws.
                                </p>
                            </div>
                        </div>

                        <div class="term-item">
                            <div class="term-number">10</div>
                            <div class="term-content">
                                <h6 class="fw-semibold mb-2">Grievance Officer</h6>
                                <p class="text-muted mb-0">
                                    Insert Name of the Office:
                                </p>
                                <p class="text-muted mb-0">
                                    Designation:
                                </p>
                                <p class="text-muted mb-0">
                                    Insert Name and Address of the Company:
                                </p>
                                <p class="text-muted mb-0">
                                    Contact us:
                                </p>
                                <p class="text-muted mb-0">
                                    Phone: Time: Monday - Friday(9:00 - 18:00)
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Privacy -->

    <style>
        /* .policy-card {
                    display: flex;
                    align-items: flex-start;
                    gap: 16px;
                    padding: 24px;
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                } */


        .policy-card.bg-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        }

        .policy-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--theme-color, #5oo9e8);
            border-radius: 10px;
            font-size: 20px;
            color: #fff;
        }

        .policy-icon.bg-primary {
            background: #5c6bc0 !important;
        }

        .policy-content h5,
        .policy-content h6 {
            color: #333;
        }

        .terms-section {
            display: flex;
            flex-direction: column;
            /* gap: 16px; */
        }

        .term-item {
            display: flex;
            gap: 16px;
            padding: 10px 20px;
            background: #fff;
            border-radius: 10px;
            /* box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06); */
            transition: all 0.3s ease;
        }

        /* .term-item:hover {
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            } */

        /* .term-number {
                width: 36px;
                height: 36px;
                min-width: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #5c6bc0 0%, #3949ab 100%);
                border-radius: 50%;
                font-weight: 600;
                font-size: 14px;
                color: #fff;
            } */

        .term-content h6 {
            color: #2c3e50;
            font-size: 15px;
        }

        .term-content p {
            font-size: 14px;
            line-height: 1.6;
            color: #6c757d;
        }

        .btn-primary {
            background: #5c6bc0;
            border-color: #5c6bc0;
        }

        .btn-primary:hover {
            background: #3949ab;
            border-color: #3949ab;
        }

        @media (max-width: 768px) {
            .policy-card {
                flex-direction: column;
                padding: 16px;
            }

            /* .term-item {
                flex-direction: column;
                padding: 16px;
            } */

            .term-number {
                width: 32px;
                height: 32px;
                min-width: 32px;
                font-size: 12px;
            }

            .tf-sp-2 {
                padding-top: 0px;
                padding-bottom: 0px;
            }

            .entry-privary {
                display: grid;
                gap: 0px;
            }

            .s-search-faq .parallax-image {
                height: 200px;
            }

            .term-item {
                display: flex;
                gap: 0px;
                padding: 10px 0px;
                background: #fff;
                border-radius: 10px;
                /* box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06); */
                transition: all 0.3s ease;
            }
        }
    </style>
@endsection
