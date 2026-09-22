from rest_framework import permissions, viewsets
from rest_framework.decorators import api_view, permission_classes
from avisos.permissions import EsAutorOAdmin
from rest_framework.response import Response


from .models import Aviso
from .serializers import AvisoSerializer


class AvisoViewSet(viewsets.ModelViewSet):
    permission_classes = [permissions.IsAuthenticatedOrReadOnly, EsAutorOAdmin]
    queryset = Aviso.objects.filter(publicado=True).select_related("categoria", "autor")
    serializer_class = AvisoSerializer

    def perform_create(self, serializer):
        serializer.save(autor=self.request.user)

    def get_queryset(self):
        qs = super().get_queryset()
        categoria = self.request.query_params.get("categoria")
        if categoria:
            qs = qs.filter(categoria_id=categoria)
        return qs

    
@api_view(["GET"])
@permission_classes([permissions.IsAuthenticated])
def yo(request):
    return Response({
        "id": request.user.id,
        "nombre": request.user.username,
        "rol": "admin" if request.user.is_staff else "autor",
    })

