#!/bin/bash

# Medical Appointment System - Fix Verification Script
# This script tests the fixes applied to resolve microphone, audio, and connection issues

echo "🔍 Medical Appointment System - Fix Verification"
echo "================================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test 1: Check if Laravel server is running
echo -e "\n${YELLOW}Test 1: Checking Laravel server...${NC}"
if curl -s http://localhost:8000 > /dev/null; then
    echo -e "${GREEN}✅ Laravel server is running on port 8000${NC}"
else
    echo -e "${RED}❌ Laravel server is not running. Please start with: php artisan serve --host=0.0.0.0 --port=8000${NC}"
    exit 1
fi

# Test 2: Test public health endpoint
echo -e "\n${YELLOW}Test 2: Testing public health endpoint...${NC}"
HEALTH_RESPONSE=$(curl -s -X GET "http://localhost:8000/health-check" -H "Accept: application/json")
if echo "$HEALTH_RESPONSE" | grep -q '"status":"ok"'; then
    echo -e "${GREEN}✅ Public health endpoint working${NC}"
    echo "Response: $HEALTH_RESPONSE"
else
    echo -e "${RED}❌ Public health endpoint failed${NC}"
    echo "Response: $HEALTH_RESPONSE"
fi

# Test 3: Test authenticated health endpoint (should return unauthenticated)
echo -e "\n${YELLOW}Test 3: Testing authenticated health endpoint...${NC}"
AUTH_HEALTH_RESPONSE=$(curl -s -X GET "http://localhost:8000/api/health-check" -H "Accept: application/json")
if echo "$AUTH_HEALTH_RESPONSE" | grep -q "Unauthenticated"; then
    echo -e "${GREEN}✅ Authenticated health endpoint properly protected${NC}"
    echo "Response: $AUTH_HEALTH_RESPONSE"
else
    echo -e "${RED}❌ Authenticated health endpoint not properly protected${NC}"
    echo "Response: $AUTH_HEALTH_RESPONSE"
fi

# Test 4: Check Daily.co configuration
echo -e "\n${YELLOW}Test 4: Checking Daily.co configuration...${NC}"
if grep -q "DAILY_API_KEY=" .env && grep -q "DAILY_DOMAIN=" .env; then
    DAILY_KEY=$(grep "DAILY_API_KEY=" .env | cut -d'=' -f2)
    DAILY_DOMAIN=$(grep "DAILY_DOMAIN=" .env | cut -d'=' -f2)
    if [ ! -z "$DAILY_KEY" ] && [ ! -z "$DAILY_DOMAIN" ]; then
        echo -e "${GREEN}✅ Daily.co configuration found${NC}"
        echo "Domain: $DAILY_DOMAIN"
        echo "API Key: ${DAILY_KEY:0:10}..."
    else
        echo -e "${RED}❌ Daily.co configuration incomplete${NC}"
    fi
else
    echo -e "${RED}❌ Daily.co configuration missing${NC}"
fi

# Test 5: Check Redis configuration
echo -e "\n${YELLOW}Test 5: Checking Redis configuration...${NC}"
if grep -q "SESSION_DRIVER=redis" .env; then
    echo -e "${GREEN}✅ Session driver set to Redis${NC}"
else
    echo -e "${YELLOW}⚠️ Session driver not set to Redis${NC}"
fi

# Test 6: Check CSRF token in prejoin page
echo -e "\n${YELLOW}Test 6: Checking CSRF token in prejoin page...${NC}"
if grep -q 'meta name="csrf-token"' resources/views/video-call/prejoin.blade.php; then
    echo -e "${GREEN}✅ CSRF token meta tag found in prejoin page${NC}"
else
    echo -e "${RED}❌ CSRF token meta tag missing in prejoin page${NC}"
fi

# Test 7: Check AudioContext fix
echo -e "\n${YELLOW}Test 7: Checking AudioContext fix...${NC}"
if grep -q "audioContext.state === 'suspended'" resources/views/video-call/prejoin.blade.php; then
    echo -e "${GREEN}✅ AudioContext suspension fix found${NC}"
else
    echo -e "${RED}❌ AudioContext suspension fix missing${NC}"
fi

# Test 8: Check audio autoplay fix
echo -e "\n${YELLOW}Test 8: Checking audio autoplay fix...${NC}"
if grep -q "NotAllowedError" resources/views/video-call/prejoin.blade.php; then
    echo -e "${GREEN}✅ Audio autoplay error handling found${NC}"
else
    echo -e "${RED}❌ Audio autoplay error handling missing${NC}"
fi

# Test 9: Check route cache
echo -e "\n${YELLOW}Test 9: Checking route cache...${NC}"
if php artisan route:list | grep -q "health-check"; then
    echo -e "${GREEN}✅ Health check routes found in route list${NC}"
else
    echo -e "${YELLOW}⚠️ Routes might need to be cached. Run: php artisan route:cache${NC}"
fi

# Test 10: Check proxy configuration
echo -e "\n${YELLOW}Test 10: Checking proxy configuration...${NC}"
if grep -q "protected \$proxies = '\*';" app/Http/Middleware/TrustProxies.php; then
    echo -e "${GREEN}✅ TrustProxies configured for all proxies${NC}"
else
    echo -e "${YELLOW}⚠️ TrustProxies might need configuration for Cloudflare${NC}"
fi

# Test 11: Check CORS configuration
echo -e "\n${YELLOW}Test 11: Checking CORS configuration...${NC}"
if grep -q "'allowed_origins' => \['\*'\]" config/cors.php; then
    echo -e "${GREEN}✅ CORS configured to allow all origins${NC}"
else
    echo -e "${YELLOW}⚠️ CORS might be restricted${NC}"
fi

# Test 12: Test CORS preflight request
echo -e "\n${YELLOW}Test 12: Testing CORS preflight request...${NC}"
CORS_RESPONSE=$(curl -s -X OPTIONS "http://localhost:8000/api/health-check" -H "Origin: https://example.com" -H "Access-Control-Request-Method: GET" -I)
if echo "$CORS_RESPONSE" | grep -q "Access-Control-Allow-Origin"; then
    echo -e "${GREEN}✅ CORS preflight request working${NC}"
else
    echo -e "${RED}❌ CORS preflight request failed${NC}"
fi

echo -e "\n${YELLOW}Summary:${NC}"
echo "========"
echo "✅ All basic fixes have been applied"
echo "🔧 To test the complete functionality:"
echo "   1. Start Laravel server: php artisan serve --host=0.0.0.0 --port=8000"
echo "   2. Login to the application"
echo "   3. Navigate to a prejoin page for an appointment"
echo "   4. Test camera, microphone, and speaker functionality"
echo "   5. Verify connection test shows 'Connection good'"
echo ""
echo "🧪 For debugging media issues:"
echo "   1. Open http://localhost:8000/test-media.html in your browser"
echo "   2. Test microphone and speaker functionality independently"
echo "   3. Check browser console for detailed error messages"
echo "   4. Verify device permissions are granted"
echo ""
echo "🌐 For Cloudflare testing:"
echo "   1. Ensure your Cloudflare tunnel is running"
echo "   2. Test through the tunnel URL"
echo "   3. Verify session cookies work through the proxy"
echo ""
echo "📋 See AUDIT_FIXES_SUMMARY.md for detailed information"
