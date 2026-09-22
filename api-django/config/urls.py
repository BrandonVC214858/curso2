from django.contrib import admin
from django.urls import include, path
from rest_framework.routers import DefaultRouter
from rest_framework.authtoken.views import obtain_auth_token

from avisos.views import AvisoViewSet, yo

router = DefaultRouter()

urlpatterns = [
    path("admin/", admin.site.urls),
    path("api/", include(router.urls)),
    path("api-auth/", include("rest_framework.urls")),
    path("api/token", obtain_auth_token),
    path("api/avisos/", AvisoViewSet.as_view({"get": "list", "post": "create"})),
    path("api/avisos/<int:pk>/", AvisoViewSet.as_view({"get": "retrieve", "put": "update", "delete": "destroy"})),
    path("api/yo/", yo),
]
