<?php

namespace Database\Seeders;

use App\Models\DeviceSpecificDiagnosis;
use Illuminate\Database\Seeder;

class DeviceSpecificDiagnosisSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [

            [
                'device_type' => 'COMPUTER (Desktop / Laptop / All-in-One)',
                'diagnosis_list' => [
                    "Earthing",
                    "Power Test",
                    "Display Output",
                    "Keyboard / Mouse / Touchpad",
                    "USB / HDMI / LAN / Audio Ports",
                    "Wi-Fi / Bluetooth",
                    "Overheating Symptoms",
                    "RAM / HDD / SSD Health",
                    "Hinge or Body Damage",
                    "Battery / Charging (Laptop only)"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'PRINTER (Includes Toner Refill Task)',
                'diagnosis_list' => [
                    "Earthing",
                    "Power & Display",
                    "Paper Jam / No Print",
                    "Print Quality Issues (blurred, faded, missing lines)",
                    "Toner/Cartridge Level",
                    "USB / LAN / Wi-Fi Connectivity",
                    "Scanner ADF / Flatbed",
                    "Noise, Dust, Physical Damage"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'CCTV (Wired & Wireless)',
                'diagnosis_list' => [
                    "Earthing",
                    "DVR/NVR Power",
                    "Booting & UI Access",
                    "Recording Test",
                    "Camera Image - Wired or Wireless",
                    "Resolution / Clarity / Night Vision",
                    "PTZ Test / Focus",
                    "DVR HDD Detection",
                    "LAN / Wi-Fi Signal Strength",
                    "Remote Access / Mobile View",
                    "SMPS, Connectors, BNC, Power Cable Test"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'SERVER',
                'diagnosis_list' => [
                    "Earthing at Rack",
                    "Power Status / Beep Test / Fans",
                    "RAID Configuration / Health",
                    "ECC RAM Testing",
                    "Backplane & Hot Swap Drives",
                    "IPMI / RDP / iLO / iDRAC Access",
                    "Network Uplink / UPS Input",
                    "Event Logs / Disk Failure Alerts",
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'NETWORKING',
                'diagnosis_list' => [
                    "Earthing",
                    "Router / Firewall Boot + Config Access",
                    "LAN Cable Punching, Speed, Tester Results",
                    "Switch Power / Port Blink Test",
                    "Patch Panel Labeling",
                    "Wi-Fi Strength",
                    "RJ45 & Keystone Crimp Quality",
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'BIOMETRIC / ACCESS CONTROL',
                'diagnosis_list' => [
                    "Earthing",
                    "Device Power ON",
                    "Fingerprint / Face Detection Response",
                    "Lock/Unlock Relay Test",
                    "Door Sensor Trigger",
                    "LAN / Wi-Fi Test",
                    "Date/Time Sync",
                    "Cloud/Server Log Push Status"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'EPABX',
                'diagnosis_list' => [
                    "Earthing",
                    "Power ON / Status LED",
                    "Incoming/Outgoing Trunk Test",
                    "Extension-to-Extension Dial",
                    "Programming Interface Access",
                    "Line Echo or Signal Distortion",
                    "Cable or Connector Break Faults"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'device_type' => 'WINDOWS & macOS SERVICE',
                'diagnosis_list' => [
                    "Earthing",
                    "System Boot / Login Credentials",
                    "OS Version, Activation",
                    "Antivirus Installed / Updated",
                    "Resource Usage / Lag / Heat",
                    "Network Connectivity",
                    "Disk Health (CHKDSK / SMART)",
                    "App Crash, BSOD, Logs",
                    "Backup Settings or Restore Point"
                ],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ];

        foreach ($rows as &$row) {
            $row['diagnosis_list'] = json_encode($row['diagnosis_list']);
        }
        unset($row);

        DeviceSpecificDiagnosis::insert($rows);
    }
}