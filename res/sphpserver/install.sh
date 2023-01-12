#!/bin/bash
full_path=$(realpath $0)
#echo $full_path
dirrespath=$(dirname $full_path)
echo "Creating Desktop Regsitery"
sudo echo "[Desktop Entry]" > "/usr/share/applications/sphpdesk.desktop"
sudo echo "Name=Sphp Desk" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Exec=$dirrespath/sphpserver-linux" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "GenericName=Sphp Server desk" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Comment=Sphp Server App" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Icon=$dirrespath/sartajphp.png" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Terminal=false" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Type=Application" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "MimeType=application/x-sphp" >> "/usr/share/applications/sphpdesk.desktop"
sudo echo "Categories=Development;IDE;" >> "/usr/share/applications/sphpdesk.desktop"
sudo cp application-x-sphp.xml /usr/share/mime/packages
sudo update-mime-database /usr/share/mime
sudo cp sartajphp.png /usr/share/icons/hicolor/scalable/mimetypes/application-x-sphp.png
sudo gtk-update-icon-cache /usr/share/icons/hicolor/ -f
sudo rm /bin/sphpdesk
sudo ln -s $dirrespath/sphpserver-linux /bin/sphpdesk
sudo cp $dirrespath/RootCA.pem /usr/local/share/ca-certificates/RootCA.crt
sudo update-ca-certificates
echo "Finished"
echo "Press any key to exit"
read -p "Press any key to continue...\n " -n1 -s
#sudo xdg-mime default "/usr/share/applications/sphpdesk.desktop" application/x-sphp


