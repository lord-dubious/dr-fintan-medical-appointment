# API.md

## Overview
This document outlines the API endpoints for the Dr. Fintan Medical Appointment system, focusing on the video consultation functionality.

## Authentication
API authentication is handled via Laravel Sanctum for token-based access for authenticated users. Daily.co API calls use a separate API key for server-to-server communication.

## Base URL
```
https://your-app-domain.com/api
```

## Endpoints

### Video Consultations

#### POST /video-consultation/create-room
Creates a new Daily.co room for a video consultation.

**Request**
```http
POST /api/video-consultation/create-room
Content-Type: application/json
Authorization: Bearer {sanctum_token}
```

**Body**
```json
{
  "appointment_id": "uuid_of_appointment"
}
```

**Response**
```json
{
  "status": "success",
  "room_url": "https://your-domain.daily.co/room-name",
  "token": "daily_access_token"
}
```

#### POST /video-consultation/join-room
Retrieves a token to join an existing Daily.co room.

**Request**
```http
POST /api/video-consultation/join-room
Content-Type: application/json
Authorization: Bearer {sanctum_token}
```

**Body**
```json
{
  "room_name": "name_of_daily_room"
}
```

**Response**
```json
{
  "status": "success",
  "token": "daily_access_token"
}
```

## Error Handling

### Error Response Format
```json
{
  "status": "error",
  "message": "Human readable error message",
  "errors": {
    "field_name": ["Error message 1", "Error message 2"]
  }
}
```

### Common Error Codes
- `400 Bad Request` - Invalid input data or missing required parameters.
- `401 Unauthorized` - Missing or invalid authentication token.
- `403 Forbidden` - User does not have permission to access the resource.
- `404 Not Found` - The requested resource was not found.
- `422 Unprocessable Entity` - Validation errors.
- `500 Internal Server Error` - An unexpected server error occurred.

## Webhooks
(Not currently applicable for this API, as Daily.co webhooks are handled internally by the application logic if configured.)

## SDKs and Libraries
- **Backend**: Laravel HTTP Client for Daily.co integration.
- **Frontend**: Daily.co JavaScript library for video call management.

## Changelog
- **v1.0.0** - Initial API endpoints for video consultation.

## Keywords <!-- #keywords -->
- api
- daily.co
- video consultation
- laravel sanctum
- endpoints
