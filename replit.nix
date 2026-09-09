{pkgs}: {
  deps = [
    pkgs.php82Packages.composer
    pkgs.php82Extensions.curl
    pkgs.php82Extensions.mbstring
  ];
}
