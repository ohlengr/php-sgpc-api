# 🪯 SGPC Audio API

A lightning-fast, unofficial public API to fetch the active audio streaming URLs for Sri Darbar Sahib (Golden Temple, Amritsar). 

## 📖 Overview
Developers building Sikh-centric mobile apps and websites often face a common issue: the SGPC provides Live Gurbani Kirtan and Daily Hukamnama audio, but their streaming server URLs and `nocache` parameters change periodically. Hardcoding these URLs inside your app will eventually cause it to break.

This API acts as a stable bridge. It constantly monitors the official SGPC website, extracts the active audio sources in real-time, caches them for performance, and serves them to your application via a clean JSON endpoint.

## 🚀 Base URL
```text
[https://api.ohlengr.com/](https://api.ohlengr.com/)
📡 Endpoint: Get Audio Links
Fetches the current, active URLs for both the Live Kirtan radio stream and the Daily Hukamnama MP3.

Request:
GET /

Response:

JSON
{
  "success": true,
  "links": {
    "liveKirtan": "[https://live.sgpc.net:8442/](https://live.sgpc.net:8442/);",
    "dailyHukamnama": "[https://hs.sgpc.net/uploadhukamnama/hukamnama.mp3](https://hs.sgpc.net/uploadhukamnama/hukamnama.mp3)"
  },
  "lastUpdated": "2026-05-13T05:30:00+00:00"
}

💻 Integration Examples
React Native / Expo (JavaScript)
Easily fetch the active links before loading your audio player (like react-native-track-player).

JavaScript
const fetchSgpcAudio = async () => {
  try {
    const response = await fetch('[https://api.ohlengr.com/](https://api.ohlengr.com/)');
    const data = await response.json();

    if (data.success) {
      console.log("Live Kirtan URL:", data.links.liveKirtan);
      console.log("Daily Hukamnama URL:", data.links.dailyHukamnama);
      
      // Pass these URLs to your audio player component
    }
  } catch (error) {
    console.error("Failed to fetch SGPC links", error);
  }
};

Swift (iOS)

func fetchSgpcAudio() {
    guard let url = URL(string: "[https://api.ohlengr.com/](https://api.ohlengr.com/)") else { return }
    
    URLSession.shared.dataTask(with: url) { data, response, error in
        if let data = data {
            // Parse your JSON response here
            if let jsonString = String(data: data, encoding: .utf8) {
                print(jsonString)
            }
        }
    }.resume()
}

Python

import requests

response = requests.get('[https://api.ohlengr.com/](https://api.ohlengr.com/)')
if response.status_code == 200:
    data = response.json()
    print("Live Kirtan URL:", data['links']['liveKirtan'])
⚡ Features
Auto-Updating: Scrapes the SGPC website to ensure links are always active and accurate.

High Performance: Implements a 1-hour rolling cache on the server to guarantee instant response times and prevent rate-limiting.

CORS Enabled: Fully open and accessible from any web browser, localhost development environment, or mobile app framework.

⚠️ Disclaimer
This is an unofficial community-built tool and is completely unaffiliated with the Shiromani Gurdwara Parbandhak Committee (SGPC). It relies on web scraping techniques. It is provided free of charge to help developers build better tools for the Sangat.