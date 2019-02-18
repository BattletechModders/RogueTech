# Flashpoint Stock Photos
These are a select set of images to be called in group conversations for HBS' BATTLETECH game. The aim is to provide general use images for Flashpoint authors in one repository. This will cut down on duplicated imagery and keep the memory footprint reasonable. Images will be in .dds format for lower GPU load. 

### Holoscreen Image Guidelines
The Holoscreen .dds files need to be inverted horizontally and flipped vertically to display correctly. A .png file needs to be inverted horizontally only. The files in the base game are either 2048x2048 or 512x512 pixels across, I believe as long as your file is square and either .png or .dds it will load correctly. A file not found will display a blank image and generate an error in the log.


This mod is to be used with ConverseTek, files would be referenced in the action to set a viewscreen image.

Currently there are only five images in the database:


screenoff - An empty image, there is no error-free way to clear the screen at this time


audioonly - A modified "lostsignal" image with the words "Audio Only" overlayed for cast members with no need for a custom image


localsrep - For some reason, HBS didn't feel the need to let us chat with him


regionmap - A map of the Rimward Periphery region the stock game takes place in


spheremap - A map of the Inner Sphere for greater context


If you are making a custom conversation and need to use your own images, copy this mod's mod.json manifest entry in to your own mod.json and name the path as appropriate. This will let the game know you want to add files to the conversation textures addendum.

### Instructions:

    Copy Flashpoint-Stock-Images folder in to Mods folder created for ModTek.
    
### ModTek
This mod needs ModTek to work:

https://github.com/BattletechModders/ModTek/releases
