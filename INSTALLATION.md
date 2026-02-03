# Installation & Setup Guide - Slider GTA Plugin

## Quick Start

Your WordPress plugin is ready! Follow these steps to activate and use it.

## Step 1: Activate the Plugin

1. Go to your WordPress admin dashboard
2. Navigate to **Plugins → Installed Plugins**
3. Find "Slider GTA" in the list
4. Click **Activate**

## Step 2: Create Your First Slider

1. In WordPress admin, go to **Sliders → Add New Slider**
2. Enter a title for your slider (e.g., "Home Page Slider")
3. Click the **Add Images** button
4. Select multiple images from your media library or upload new ones
5. Drag and drop images to reorder them as needed
6. Click **Publish**
7. Copy the shortcode that appears (e.g., `[slider_gta id="123"]`)

## Step 3: Display Your Slider

### Option A: Using Shortcode

Paste the shortcode in any:
- Post content
- Page content
- Text widget
- Custom HTML block

Example: `[slider_gta id="123"]`

### Option B: Using Elementor (if installed)

1. Edit a page with Elementor
2. In the left panel, search for "Slider GTA"
3. Drag the "Slider GTA" widget onto your page
4. In the widget settings, select your slider from the dropdown
5. Adjust styling options if needed
6. Click **Update** or **Publish**

**Note**: If Elementor is not installed, that's perfectly fine! The plugin works without it using shortcodes.

## Creating Multiple Sliders

1. Go to **Sliders → Add New Slider** for each new slider
2. Each slider gets its own unique ID
3. Use different shortcodes for different sliders:
   - Homepage: `[slider_gta id="123"]`
   - Gallery: `[slider_gta id="124"]`
   - Products: `[slider_gta id="125"]`

## Managing Sliders

### Edit a Slider
1. Go to **Sliders → All Sliders**
2. Click on the slider title to edit
3. Add/remove images or reorder them
4. Click **Update**

### Delete a Slider
1. Go to **Sliders → All Sliders**
2. Hover over the slider and click **Trash**

### Copy Shortcode
- The shortcode is visible in the "Shortcode" column on the All Sliders page
- Click to select and copy

## Features Overview

✅ **3D Coverflow Effect**: Beautiful rotating slider with depth
✅ **Auto-play**: Slides automatically change every 3 seconds
✅ **Navigation**: Arrow buttons for manual control
✅ **Pagination**: Dots showing current slide position
✅ **Touch Gestures**: Swipe on mobile and tablets
✅ **Responsive**: Works on all screen sizes
✅ **Loop Mode**: Continuous sliding without end

## Troubleshooting

### Slider not appearing?
- Check that the slider is **Published** (not draft)
- Verify the slider ID in your shortcode matches
- Make sure images are added to the slider

### Images not loading?
- Ensure images are properly uploaded to WordPress media library
- Check file permissions on uploads folder
- Clear browser cache

### Elementor widget missing?
- This is normal if Elementor is not installed
- Install Elementor plugin to access the widget
- Plugin works perfectly fine with just shortcodes

### Styling issues?
- Clear your site cache if using a caching plugin
- Check for theme CSS conflicts
- Try adding `!important` to custom CSS if needed

## Customization

### Change Auto-play Speed
Edit: `includes/class-slider-gta-shortcode.php` (around line 80)
Change: `delay: 3000` to your desired milliseconds

### Adjust Slide Size
Edit: `assets/css/slider-gta.css`
Modify: `.swiper-slide` width and height values

### Change Number of Visible Slides
Edit: `assets/css/slider-gta.css`
Adjust: `.swiper-slide` width (smaller = more slides visible)

## File Locations

- **Main Plugin File**: `slider-gta.php`
- **Styles**: `assets/css/slider-gta.css`
- **Scripts**: `assets/js/slider-gta.js`
- **Admin Styles**: `assets/css/admin.css`
- **Admin Scripts**: `assets/js/admin.js`
- **Swiper Library**: `assets/js/swiper-bundle.min.js`

## Need Help?

1. Check the README.md file for detailed documentation
2. Review the troubleshooting section above
3. Contact your developer for custom modifications

## What Makes This Plugin Safe?

✅ **No Elementor Errors**: Plugin checks if Elementor is installed before loading widget code
✅ **WordPress Standards**: Follows WordPress coding standards and best practices
✅ **Secure**: Properly sanitized inputs and nonce verification
✅ **No Conflicts**: Uses namespaced functions and proper WordPress hooks

Enjoy your new slider plugin! 🎉
