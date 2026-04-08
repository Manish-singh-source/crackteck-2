<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    private array $staticData = [
        // t_n_c_amc_remote,
        // t_n_c_amc_Onsite,
        // t_n_c_ecommerce_order,
        // t_n_c_quick,
        // t_n_c_installation,
        // t_n_c_repair,

        't_n_c_amc_remote' => [
            'title' => 'Terms and Conditions AMC Remote Support Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Remote Support Services. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Remote support services are provided only for devices covered under a valid AMC agreement.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Clients must provide accurate device identification details, including MAC ID where applicable, for authentication.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Remote support is dependent on active internet connectivity at the client’s premises.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Support will be provided during standard business hours unless otherwise agreed in writing.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Issues requiring physical intervention will be treated as onsite service requests.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Hardware-related faults cannot be resolved remotely and may require onsite inspection.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. The client is responsible for maintaining data backups prior to remote access sessions.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '8. Unauthorized software installations, malware infections, or system alterations may fall outside AMC coverage. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '9. Remote access will be used strictly for maintenance, diagnostics, and troubleshooting purposes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],

            ]
        ],
        't_n_c_amc_Onsite' => [
            'title' => 'Terms and Conditions AMC Onsite Support Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Onsite Services. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Onsite services will be delivered as per the scope defined in the AMC agreement.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Preventive maintenance visits will be scheduled mutually between both parties.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Response time for service calls will be as agreed in the AMC contract.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Spare parts and consumables are chargeable unless explicitly included.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Damage caused by power fluctuations, liquid spills, mishandling, or external factors is excluded.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. The client must provide proper working conditions including power supply and access to equipment.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Additional visits beyond the agreed scope may be billed separately.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],
            ]
        ],
        't_n_c_ecommerce_order' => [
            'title' => 'Terms and Conditions E-Commerce Orders',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of E-Commerce Orders. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. All orders are subject to product availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Product images displayed online are for reference purposes only.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Dispatch timelines are indicative and may vary based on logistics providers.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Returns are accepted only for damaged or defective items reported within 48 hours of delivery.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. An unboxing video may be required for damage claims.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Shipping charges are non-refundable unless the product is defective.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Cancellation requests are accepted only before dispatch.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '8. Warranty, where applicable, will be governed by manufacturer terms.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],
            ]
        ],
        't_n_c_quick' => [
            'title' => 'Terms and Conditions Quick Commerce Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Quick Commerce Services. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Delivery timelines are estimates and not guaranteed.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Service availability depends on delivery location coverage.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Orders once processed may not be modified or cancelled.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Partial deliveries may occur based on stock availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Delays caused by traffic, weather, or logistics partners are beyond control.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Payment must be completed prior to dispatch unless otherwise agreed.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],
            ]
        ],
        't_n_c_installation' => [
            'title' => 'Terms and Conditions Installation Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Installation Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Installation will be scheduled based on technician availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. The client must ensure site readiness prior to technician visit.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Electrical points, wiring, and infrastructure must be arranged by the client. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Standard installation is included; additional work is chargeable.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Revisit due to incomplete site readiness may attract additional charges.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Demonstration will be provided at the time of installation.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],
            ]
        ],
        't_n_c_repair' => [
            'title' => 'Terms and Conditions Repair Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Repair Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Devices will be inspected prior to confirming repair feasibility.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Repair timelines depend on fault diagnosis and spare availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Clients must back up all data before submitting equipment for repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. The company is not responsible for data loss during repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Repair warranty, if provided, is limited to replaced or repaired components only.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Additional charges may apply for physical or liquid damage.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Devices not collected within 30 days may incur storage charges.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '8. Advance payment may be required for special-order spare parts.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],
            ]
        ],
        'privacy_policy' => [
            'title' => 'Privacy Policy',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Please read these Privacy Policy carefully before using our platform.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Introduction'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'This Privacy Policy describes how 9607788836 and its affiliates (collectively "9607788836, we, our, us") collect, use, share, protect or otherwise process your information/ personal data through our website www.srbcomputers.com (hereinafter referred to as Platform). Please note that you may be able to browse certain sections of the Platform without registering with us.We do not offer any product/service under this Platform outside India and your personal data will primarily be stored and processed in India. By visiting this Platform, providing your information or availing any product/service offered on the Platform, you expressly agree to be bound by the terms and conditions of this Privacy Policy, the Terms of Use and the applicable service/product terms and conditions, and agree to be governed by the laws of India including but not limited to the laws applicable to data protection and privacy. If you do not agree please do not use or access our Platform.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Collection'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We collect your personal data when you use our Platform, services or otherwise interact with us during the course of our relationship.and related information provided from time to time. Some of the information that we may collect includes but is not limited to personal data / information provided to us during sign-up/registering or using our Platform such as name, date of birth, address, telephone/mobile number, email IDand/or any such information shared as proof of identity or address. Some of the sensitive personal data may be collected with your consent, such as your bank account or credit or debit card or other payment instrument information or biometric information such as your facial features or physiological information (in order to enable use of certain features when opted for, available on the Platform) etc all of the above being in accordance with applicable law(s) You always have the option to not provide information, by choosing not to use a particular service or feature on the Platform. We may track your behaviour, preferences, and other information that you choose to provide on our Platform. This information is compiled and analysed on an aggregated basis. We will also collect your information related to your transactions on Platform and such third-party business partner platforms. When such a third-party business partner collects your personal data directly from you, you will be governed by their privacy policies. We shall not be responsible for the third-party business partner’s privacy practices or the content of their privacy policies, and we request you to read their privacy policies prior to disclosing any information. If you receive an email, a call from a person/association claiming to be 9607788836 seeking any personal data like debit/credit card PIN, net-banking or mobile banking password, we request you to never provide such information. If you have already revealed such information, report it immediately to an appropriate law enforcement agency.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Usage'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We use personal data to provide the services you request. To the extent we use your personal data to market to you, we will provide you the ability to opt-out of such uses. We use your personal data to assist sellers and business partners in handling and fulfilling orders; enhancing customer experience; to resolve disputes; troubleshoot problems; inform you about online and offline offers, products, services, and updates; customise your experience; detect and protect us against error, fraud and other criminal activity; enforce our terms and conditions; conduct marketing research, analysis and surveys; and as otherwise described to you at the time of collection of information. You understand that your access to these products/services may be affected in the event permission is not provided to us.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Sharing'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We may share your personal data internally within our group entities, our other corporate entities, and affiliates to provide you access to the services and products offered by them. These entities and affiliates may market to you as a result of such sharing unless you explicitly opt-out. We may disclose personal data to third parties such as sellers, business partners, third party service providers including logistics partners, prepaid payment instrument issuers, third-party reward programs and other payment opted by you. These disclosure may be required for us to provide you access to our services and products offered to you, to comply with our legal obligations, to enforce our user agreement, to facilitate our marketing and advertising activities, to prevent, detect, mitigate, and investigate fraudulent or illegal activities related to our services. We may disclose personal and sensitive personal data to government agencies or other authorised law enforcement agencies if required to do so by law or in the good faith belief that such disclosure is reasonably necessary to respond to subpoenas, court orders, or other legal process. We may disclose personal data to law enforcement offices, third party rights owners, or others in the good faith belief that such disclosure is reasonably necessary to: enforce our Terms of Use or Privacy Policy; respond to claims that an advertisement, posting or other content violates the rights of a third party; or protect the rights, property or personal safety of our users or the general public.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Security Precautions'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'To protect your personal data from unauthorised access or disclosure, loss or misuse we adopt reasonable security practices and procedures. Once your information is in our possession or whenever you access your account information, we adhere to our security guidelines to protect it against unauthorised access and offer the use of a secure server. However, the transmission of information is not completely secure for reasons beyond our control. By using the Platform, the users accept the security implications of data transmission over the internet and the World Wide Web which cannot always be guaranteed as completely secure, and therefore, there would always remain certain inherent risks regarding use of the Platform. Users are responsible for ensuring the protection of login and password records for their account.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Data Deletion and Retention'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'You have an option to delete your account by visiting your profile and settings on our Platform , this action would result in you losing all information related to your account. You may also write to us at the contact information provided below to assist you with these requests. We may in event of any pending grievance, claims, pending shipments or any other services we may refuse or delay deletion of the account. Once the account is deleted, you will lose access to the account. We retain your personal data information for a period no longer than is required for the purpose for which it was collected or as required under any applicable law. However, we may retain data related to you if we believe it may be necessary to prevent fraud or future abuse or for other legitimate purposes. We may continue to retain your data in anonymised form for analytical and research purposes.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Your Rights'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'You may access, rectify, and update your personal data directly through the functionalities provided on the Platform.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Consent'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'By visiting our Platform or by providing your information, you consent to the collection, use, storage, disclosure and otherwise processing of your information on the Platform in accordance with this Privacy Policy. If you disclose to us any personal data relating to other people, you represent that you have the authority to do so and permit us to use the information in accordance with this Privacy Policy. You, while providing your personal data over the Platform or any partner platforms or establishments, consent to us (including our other corporate entities, affiliates, lending partners, technology partners, marketing channels, business partners and other third parties) to contact you through SMS, instant messaging apps, call and/or e-mail for the purposes specified in this Privacy Policy. You have an option to withdraw your consent that you have already provided by writing to the Grievance Officer at the contact information provided below. Please mention “Withdrawal of consent for processing personal data” in your subject line of your communication. We may verify such requests before acting on our request. However, please note that your withdrawal of consent will not be retrospective and will be in accordance with the Terms of Use, this Privacy Policy, and applicable laws. In the event you withdraw consent given to us under this Privacy Policy, we reserve the right to restrict or deny the provision of our services for which we consider such information to be necessary.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Changes to this Privacy Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Please check our Privacy Policy periodically for changes. We may update this Privacy Policy to reflect changes to our information practices. We may alert / notify you about the significant changes to the Privacy Policy, in the manner as may be required under applicable laws.'
                ],
                [
                    'type' => 'heading',
                    'text' => 'Grievance Officer'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Insert Name of the Office: </br>
                    Designation: </br>
                    Insert Name and Address of the Company: </br>
                    Contact us: </br>
                    Phone: Time: Monday - Friday(9:00 - 18:00)'
                ],

            ]
        ],
        't_n_c' => [
            'title' => 'Terms & Conditions',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Please read these Terms & Conditions carefully before using our platform.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. This document is an electronic record in terms of Information Technology Act, 2000 and rules there under as applicable and the amended provisions pertaining to electronic records in various statutes as amended by the Information Technology Act, 2000. This electronic record is generated by a computer system and does not require any physical or digital signatures.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. This document is published in accordance with the provisions of Rule 3 (1) of the InformationTechnology (Intermediaries guidelines) Rules, 2011 that require publishing the rules and regulations, privacy policy and Terms of Use for access or usage of domain name www.srbcomputers.com ("Website"), including the related mobile site and mobile application (hereinafter referred to as "Platform").'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. The Platform is owned by 9607788836, a company incorporated under the Companies Act, 1956 with its registered office at GROUND, SHOP NO-12, VAGHEAL PADA, RAJIVALI ROAD, SATIVALI, VASAI EAST, Palghar, Maharashtra, 401208 (hereinafter referred to as ‘Platform Owner’, "we", "us", "our").'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Your use of the Platform and services and tools are governed by the following terms and conditions (“Terms of Use”) as applicable to the Platform including the applicable policies which are incorporated herein by way of reference. If You transact on the Platform, You shall be subject to the policies that are applicable to the Platform for such transaction. By mere use of the Platform, You shall be contracting with the Platform Owner and these terms and conditions including the policies constitute Your binding obligations, with Platform Owner. These Terms of Use relate to your use of our website, goods (as applicable) or services (as applicable) (collectively, "Services"). Any terms and conditions proposed by You which are in addition to or which conflict with these Terms of Use are expressly rejected by the Platform Owner and shall be of no force or effect. These Terms of Use can be modified at any time without assigning any reason. It is your responsibility to periodically review these Terms of Use to stay informed of updates.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. For the purpose of these Terms of Use, wherever the context so requires ‘you’, "your" or ‘user’ shall mean any natural or legal person who has agreed to become a user/buyer on the Platform.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. ACCESSING, BROWSING OR OTHERWISE USING THE PLATFORM INDICATES YOUR AGREEMENT TO ALL THE TERMS AND CONDITIONS UNDER THESE TERMS OF USE, SO PLEASE READ THE TERMS OF USE CAREFULLY BEFORE PROCEEDING.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. The use of Platform and/or availing of our Services is subject to the following Terms of Use:'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* To access and use the Services, you agree to provide true, accurate and complete information to us during and after registration, and you shall be responsible for all acts done through the use of your registered account on the Platform.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials offered on this website or through the Services, for any specific purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Your use of our Services and the Platform is solely and entirely at your own risk and discretion for which we shall not be liable to you in any manner. You are required to independently assess and ensure that the Services meet your requirements.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The contents of the Platform and the Services are proprietary to us and are licensed to us. You will not have any authority to claim any intellectual property rights, title, or interest in its contents. The contents includes and is not limited to the design, layout, look and graphics.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* You acknowledge that unauthorized use of the Platform and/or the Services may lead to action against you as per these Terms of Use and/or applicable laws.'
                ],

                [
                    'type' => 'paragraph',
                    'text' => '* You agree to pay us the charges associated with availing the Services.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* You agree not to use the Platform and/ or Services for any purpose that is unlawful, illegal or forbidden by these Terms, or Indian or local laws that might apply to you.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* You agree and acknowledge that website and the Services may contain links to other third party websites. On accessing these links, you will be governed by the terms of use, privacy policy and such other policies of such third party websites. These links are provided for your convenience for provide further information.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* You understand that upon initiating a transaction for availing the Services you are entering into a legally binding and enforceable contract with the Platform Owner for the Services.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* You shall indemnify and hold harmless Platform Owner, its affiliates, group companies (as applicable) and their respective officers, directors, agents, and employees, from any claim or demand, or actions including reasonable attorney`s fees, made by any third party or penalty imposed due to or arising out of Your breach of this Terms of Use, privacy Policy and other Policies, or Your violation of any law, rules or regulations or the rights (including infringement of intellectual property rights) of a third party.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Notwithstanding anything contained in these Terms of Use, the parties shall not be liable for any failure to perform an obligation under these Terms if performance is prevented or delayed by a force majeure event.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* These Terms and any dispute or claim relating to it, or its enforceability, shall be governed by and construed in accordance with the laws of India.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All disputes arising out of or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts in Vasai and Maharashtra.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All concerns or communications relating to these Terms must be communicated to us using the contact information provided on this website'
                ],
            ]
        ],
        'help_n_support' => [
            'title' => 'Help & Support',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Help & Support'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Contact No: +91 88288 13603'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Email: satyam@srbcomputers.com'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. All devices will be inspected before confirming repair feasibility.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Repair timelines depend on fault diagnosis and spare parts availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Clients must back up all data before submitting devices for repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. The company is not responsible for any data loss during repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Repair warranty (if applicable) is limited to repaired or replaced components only.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Additional charges may apply for devices with physical or liquid damage.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Devices not collected within 30 days may incur storage charges.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '8. Advance payment may be required for special-order spare parts.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Any disputes shall be subject to the jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to these Terms & Conditions.'
                ],
            ]
        ],


    ];

    public function getStaticContent(string $key): JsonResponse
    {
        if (isset($this->staticData[$key])) {
            return response()->json([
                'success' => true,
                'data' => $this->staticData[$key],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Static content not found',
        ], 404);
    }

    public function getAllStaticContent(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->staticData,
        ]);
    }

    public function getAvailableKeys(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'keys' => array_keys($this->staticData),
        ]);
    }
}
