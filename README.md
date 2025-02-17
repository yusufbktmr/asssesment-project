**Proje Adı: E-Ticaret API Sistemi**

**Proje Tanımı**

Bu proje, bir e-ticaret platformu için tasarlanmış bir RESTful API’dir. Müşterilerin sipariş oluşturması, güncellemesi ve silmesi gibi temel işlevleri destekler. Aynı zamanda siparişlere özel indirim sistemleri de entegre edilmiştir.

**Kullanılan Teknolojiler ve Araçlar**

Laravel Framework, MySQL, Postman, Docker, PHP 8.x

**Mimari ve Design Pattern’ler**

1. Repository Pattern

Veri tabanı ile uygulama arasındaki iş mantığını ayırmak için kullanıldı.

İlgili veri tabanı işlemleri, Repository katmanından yönetilir. Bu sayede kodun test edilebilirliği artırılmıştır.

2. Service Layer

Business logic (iş mantığı) bu katmanda toplanır. Controller’lar yalnızca HTTP isteklerini yönetir.

Sipariş ve indirim hesaplama gibi karmaşık işlemler burada gerçekleştirilir.

3. Custom Validation Rules

Laravel’in özel validation kuralları kullanılarak, belirli şartları karşılayan kurallar yazılmıştır (örneğin, ürün stoğunun kontrol edilmesi).

4. Exception Handling

Tüm hata durumları özel çözüm yöntemleriyle ele alınmış ve anlamlı hata mesajları dönülmüştür.

5. Single Responsibility Principle (SRP)

Her bir class ya da fonksiyon yalnızca bir amaca hizmet eder.

**Özellikler**

1. Sipariş CRUD İşlemleri

Yeni sipariş oluşturma.

Mevcut bir siparişi silme.

Siparişi listeleme.

2. İndirim Sistemleri

Siparişlerde şu indirim kuralları uygulanır:

1000 TL ve üzeri siparişlerde %10 indirim:

Sipariş toplam tutarı 1000 TL'yi geçtiğinde uygulanır.

2 kategorisine ait bir ürünün 6 adet alınması durumunda 1 adet ürün bedava verilir:

Bu kategoriye ait ürünlerin toplam miktarı kontrol edilir ve buna göre indirim hesaplanır.

1 kategorisine ait iki veya daha fazla ürün alınırsa, en ucuz ürünün fiyatından %20 indirim:

Bu kategoriye ait ürünlerden 1 adetine ve fiyat bilgilerine göre indirim uygulanır.

3. Veritabanı Yapısı

Orders Tablosu: Siparişin temel bilgileri.

OrderItems Tablosu: Siparişe ait ürünlerin detayları.

OrderDiscounts Tablosu: Siparişe uygulanan indirimlerin detayları.

Discounts Tablosu: Ön tanımlı indirim kuralları.

Products Tablosu: Ürün bilgileri ve stok detayları.

Customers Tablosu: Müşteri bilgileri.

4. Validasyonlar

Gelen isteklerde parametreler Laravel’in özel FormRequest sınıfları ile validate edilir.

Validasyon kuralları:

Müşteri ID var mı?

Ürün stoğu yeterli mi?

Çalışma Yapısı

1. Controller Yapısı

Controller’lar yalnızca gelen HTTP isteklerini ele alır ve ilgili servislere istekleri yönlendirir. İşlemlerin iş mantığı service katmanında uygulanır.

2. Service Yapısı

Servisler, business logic’in tutulduğu yerlerdir. İşlevsel mantıkların karmaşıklığını azaltmak ve tekrar eden kodu minimize etmek için kullanılır.

3. Repository Yapısı

Repository, veri tabanı işlemlerini soyutlamak için kullanılmıştır.

4. Exception Handling

Hatalar özel mesajlarla anlamlı bir hale getirilir.

Laravel’in Handler yapısı kullanılmıştır.

**Projede MakeFile mevcuttur. Proje çekildikten sonra**
`make up`
**komutunu çalıştırmak yeterlidir.**
.env File 'make up' komutu ile oluşmaktadır. Postman collection'ı proje içerisinden RestApi Collection.postman_collection.json içerisinde bulabilirsiniz.
