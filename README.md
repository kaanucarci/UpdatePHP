Update PHP, temel anlamda bir versiyon kontrol sistemi olarak geliştirilmiştir. Bu proje, birden fazla web projesine sahip olan ve bu projelerde aynı modülleri kullanan geliştiriciler için tasarlanmıştır.
Örneğin, 30 adet web projeniz varsa ve bir projede güncelleme yaptığınızda, Update PHP diğer 29 projedeki kaynak kodlarını otomatik olarak günceller.
Kullanıcı, güncelleme yapılan web sayfasının URL'sini ve güncellenen dosya isimlerini Update PHP'ye sağlar.
Update PHP, önce güncellenen kodları alır, ardından güncellenmemiş olan projelerin yedeklerini alarak yeni kodlarla günceller. 
Bu sayede, tüm projelerde tutarlılık sağlanır ve manuel güncellemelerden kaynaklanan hatalar önlenir.
Böyle bir projem var ve bütün proje 3 klasörden oluşuyor: UpdatePHP, UpdatedFTP, FtpToBeUpdated.

UpdatePHP: Bütün sistemin çalıştığı katman, güncellediğiniz FTP'nin URL'sini ve güncelleme yaptığınız dosya isimlerini girdiğiniz kısım.

UpdatedFTP: Güncel olan kodların alınacağı katman, sistemin doğru çalışması için örnek URL; www.example.com/.

FtpToBeUpdated: Güncellenmesini istediğiniz FTP'lerin ana dizininde olması gerekiyor.
