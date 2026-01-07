#!/bin/bash

# 1. Clear Laravel Cache
echo "🧹 Clearing Laravel cache..."
php artisan optimize:clear

# 2. Ask for commit message
echo "📝 Enter your commit message:"
read message

# 3. Get changes for the description
changes=$(git status --short)

# 4. Git workflow
echo "🚀 Adding files..."
git add .

echo "💾 Committing changes..."
# Using printf to handle the newlines correctly for the commit body
final_msg=$(printf "$message\n\n# Files modified:\n$changes")
git commit -m "$final_msg"

echo "📤 Pushing to repository..."
git push

echo "✅ Done! All changes are live."