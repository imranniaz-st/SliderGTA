# Slider GTA - WordPress Plugin

A beautiful, responsive image slider plugin for WordPress with Swiper.js integration, multiple slider support, shortcodes, and Elementor compatibility.

## Features

✅ **Multiple Sliders**: Create unlimited sliders with different images
✅ **Shortcode Support**: Use `[slider_gta id="123"]` anywhere in WordPress
✅ **Elementor Widget**: Drag-and-drop widget for Elementor page builder
✅ **Safe Elementor Detection**: No errors if Elementor is not installed
✅ **Beautiful 3D Coverflow Effect**: Eye-catching slider with smooth transitions
✅ **Responsive Design**: Works perfectly on all devices
✅ **Easy Image Management**: Upload multiple images with drag-and-drop reordering
✅ **Auto-play**: Automatic slide transitions with customizable timing

## Installation

1. Upload the `SliderGTA` folder to `/wp-content/plugins/`
2. Download Swiper JS bundle from: https://unpkg.com/swiper@8/swiper-bundle.min.js
3. Save the Swiper JS file to: `assets/js/swiper-bundle.min.js`
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Go to **Sliders** menu in WordPress admin to create your first slider

## Important: Swiper JS Library

This plugin requires the Swiper JS library to function. Please download it from:
https://unpkg.com/swiper@8/swiper-bundle.min.js

And place it in:
`wp-content/plugins/SliderGTA/assets/js/swiper-bundle.min.js`

Alternatively, you can download it using this command in the plugin directory:
```bash
curl -o assets/js/swiper-bundle.min.js https://unpkg.com/swiper@8/swiper-bundle.min.js
```

## Usage

### Creating a Slider

1. Go to **Dashboard → Sliders → Add New Slider**
2. Enter a slider title
3. Click **Add Images** to upload images
4. Drag and drop to reorder images
5. Click **Publish**
6. Copy the generated shortcode

### Using Shortcodes

Insert the shortcode in any post, page, or text widget:
```
[slider_gta id="123"]
```
Replace `123` with your slider ID.

### Using with Elementor

1. Edit a page with Elementor
2. Search for "Slider GTA" widget in the widget panel
3. Drag the widget to your page
4. Select your slider from the dropdown
5. Customize styling options
6. Preview and publish

**Note**: If Elementor is not installed, the plugin will work normally without any errors. The Elementor widget simply won't be available.

### Multiple Sliders

You can create as many sliders as you need:
- Each slider has its own unique ID
- Use different shortcodes for different sliders
- Place multiple sliders on the same page
- Each slider instance works independently

## Slider Settings

The slider includes these features:
- 3D Coverflow effect
- Center-focused display
- Shows 7 slides at once (1 active + 3 on each side)
- Smooth scale transitions
- Auto-play with 3-second delay
- Navigation arrows
- Pagination dots
- Loop mode for continuous sliding
- Touch/swipe gestures support

## Customization

### CSS Customization

You can customize the slider appearance by modifying:
`assets/css/slider-gta.css`

### JavaScript Customization

Slider behavior can be adjusted in:
`includes/class-slider-gta-shortcode.php` (line ~75)

Adjust these Swiper parameters:
- `delay`: Auto-play delay in milliseconds
- `rotate`: Coverflow rotation angle
- `depth`: 3D depth effect
- `modifier`: Scale modifier
- `slidesPerView`: Number of visible slides

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Swiper.js 8.x (included via CDN or local file)
- jQuery (included with WordPress)

## Optional Requirements

- Elementor Page Builder (for Elementor widget functionality)

## File Structure

```
SliderGTA/
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── slider-gta.css
│   └── js/
│       ├── admin.js
│       ├── slider-gta.js
│       └── swiper-bundle.min.js (DOWNLOAD THIS)
├── includes/
│   ├── elementor/
│   │   ├── class-slider-gta-elementor.php
│   │   └── widgets/
│   │       └── slider-widget.php
│   ├── class-slider-gta.php
│   ├── class-slider-gta-admin.php
│   └── class-slider-gta-shortcode.php
├── index.html (original demo)
├── slider-gta.php (main plugin file)
└── README.md
```

## Troubleshooting

**Problem**: Slider doesn't display
- **Solution**: Make sure Swiper JS file is properly downloaded to `assets/js/swiper-bundle.min.js`

**Problem**: Images not showing
- **Solution**: Check that images are properly uploaded and the slider is published

**Problem**: Elementor widget not appearing
- **Solution**: This is normal if Elementor is not installed. Install Elementor to use the widget feature.

**Problem**: Shortcode displays but no slider
- **Solution**: Verify the slider ID is correct and the slider is published

## Support

For issues, questions, or contributions, please contact the plugin developer.

## License

GPL2 - This plugin is free software and comes with ABSOLUTELY NO WARRANTY.

## Credits

- Swiper.js by Vladimir Kharlampidi
- Developed for WordPress
- Elementor integration with safe error handling

## Changelog

### Version 1.0.0
- Initial release
- Multiple slider support
- Shortcode functionality
- Elementor widget with safe loading
- Admin interface with image management
- Drag-and-drop image reordering
- Responsive design
- Auto-play feature
