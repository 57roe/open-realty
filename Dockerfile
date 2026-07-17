# Fix write permissions the installer requires (paths are under src/)
RUN chmod -R 775 \
    src/api \
    src/include \
    src/images/listing_photos \
    src/images/user_photos \
    src/images/vtour_photos \
    src/images/page_upload \
    src/images/blog_uploads \
    src/files/listings \
    src/files/users \
    src/addons \
    src/files/browsercap_cache \
    src/files/download_cache \
    && chown -R www-data:www-data src/api src/include src/images src/files src/addons