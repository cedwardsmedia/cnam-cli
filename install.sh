/usr/bin/php src/composer.phar self-update
/usr/bin/php src/composer.phar install -d src
echo "Installing CNAM"
mkdir /usr/local/share/cnam-cli/
cp -R . /usr/local/share/cnam-cli/
chmod +x /usr/local/share/cnam-cli/cnam.php
ln -s /usr/local/share/cnam-cli/cnam.php /usr/local/bin/cnam
cp share/man/man1/cnam.1 /usr/share/man/man1/cnam.1
echo "Installation Complete"
echo "Run 'cnam setup' to set your EveryoneAPI credentials"
